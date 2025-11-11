<?php
header('Content-Type: application/json; charset=utf-8');

// Para debug, vamos ativar temporariamente a exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle PUT request
$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'PUT') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    require_once __DIR__ . '/../../config/database.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }

    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid JSON input: ' . json_last_error_msg()]);
        exit;
    }

    $required_fields = ['id', 'first_name', 'last_name', 'date_of_birth', 'email', 'primary_phone', 'salary', 'department_id', 'role_id'];
    foreach ($required_fields as $field) {
        if (!isset($input[$field]) || $input[$field] === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
            exit;
        }
    }

    $employee_id = (int)$input['id'];
    if ($employee_id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid employee ID']);
        exit;
    }

    $check_stmt = $pdo->prepare('SELECT id FROM employees WHERE id = ? AND status <> "fired"');
    $check_stmt->execute([$employee_id]);
    if (!$check_stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Employee not found']);
        exit;
    }

    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid email format']);
        exit;
    }

    if (!is_numeric($input['salary']) || $input['salary'] < 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid salary value']);
        exit;
    }

    if (!is_numeric($input['department_id']) || $input['department_id'] <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid department']);
        exit;
    }

    if (!is_numeric($input['role_id']) || $input['role_id'] <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid role']);
        exit;
    }

    if (!array_key_exists('secondary_phone', $input)) {
        // campo ausente no request -> NULL
        $secondaryPhone = null;
    } else {
        // campo presente (pode vir vazio "")
        $tmp = trim($input['secondary_phone']);
        // Normalizar string vazia para NULL para evitar conflitos
        $secondaryPhone = ($tmp === '') ? null : $tmp;
    }

    $address = isset($input['address']) ? trim($input['address']) : '';

    $update_stmt = $pdo->prepare('
        UPDATE employees SET 
            first_name = :first_name,
            last_name = :last_name,
            birthday = :date_of_birth,
            email = :email,
            phone_number = :primary_phone,
            second_phone_number = :secondary_phone,
            salary = :salary,
            address = :address,
            department_id = :department_id,
            role_id = :role_id,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
    ');

    $success = $update_stmt->execute([
        ':first_name' => trim($input['first_name']),
        ':last_name' => trim($input['last_name']),
        ':date_of_birth' => $input['date_of_birth'],
        ':email' => trim($input['email']),
        ':primary_phone' => trim($input['primary_phone']),
        ':secondary_phone' => $secondaryPhone, 
        ':salary' => (float)$input['salary'],
        ':address' => $address,
        ':department_id' => (int)$input['department_id'],
        ':role_id' => (int)$input['role_id'],
        ':id' => $employee_id
    ]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Employee updated successfully'
        ]);
    } else {
        $errorInfo = $update_stmt->errorInfo();
        throw new Exception('Database update failed: ' . ($errorInfo[2] ?? 'Unknown error'));
    }

} catch (PDOException $e) {
    error_log("PDOException in update_employee.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    error_log("Exception in update_employee.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
?>
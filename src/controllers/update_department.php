<?php
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 1);
error_reporting(E_ALL);

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

    $required_fields = ['id', 'name', 'description', 'status'];
    foreach ($required_fields as $field) {
        if (!isset($input[$field]) || $input[$field] === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
            exit;
        }
    }

    $department_id = (int)$input['id'];
    if ($department_id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid department ID']);
        exit;
    }

    // Check if the department exists.
    $check_stmt = $pdo->prepare('SELECT id FROM departments WHERE id = ?');
    $check_stmt->execute([$department_id]);
    if (!$check_stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Department not found']);
        exit;
    }

    $valid_statuses = ['active', 'inactive', 'under_reconstruction'];
    if (!in_array($input['status'], $valid_statuses)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid status value. Must be: active, inactive, or under_reconstruction']);
        exit;
    }

    $name = trim($input['name']);
    if (empty($name)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Department name cannot be empty']);
        exit;
    }

    $description = trim($input['description']);
    if (empty($description)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Department description cannot be empty']);
        exit;
    }

    // Process short_name (optional)
    $short_name = isset($input['short_name']) ? trim($input['short_name']) : '';

    // Check if another department with the same name already exists (excluding the current one).
    $check_duplicate_stmt = $pdo->prepare('
        SELECT id FROM departments 
        WHERE name = :name AND id != :id
    ');
    $check_duplicate_stmt->execute([
        ':name' => $name,
        ':id' => $department_id
    ]);
    
    if ($duplicate = $check_duplicate_stmt->fetch()) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'A department with this name already exists']);
        exit;
    }

    // Check if another department already exists with the same short_name (only if it's not empty).
    if (!empty($short_name)) {
        $check_short_name_stmt = $pdo->prepare('
            SELECT id FROM departments 
            WHERE short_name = :short_name AND id != :id
        ');
        $check_short_name_stmt->execute([
            ':short_name' => $short_name,
            ':id' => $department_id
        ]);
        
        if ($duplicate_short = $check_short_name_stmt->fetch()) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'A department with this short name already exists']);
            exit;
        }
    }

    // Update the department
    $update_stmt = $pdo->prepare('
        UPDATE departments SET 
            name = :name,
            short_name = :short_name,
            description = :description,
            status = :status,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
    ');

    $success = $update_stmt->execute([
        ':name' => $name,
        ':short_name' => $short_name,
        ':description' => $description,
        ':status' => $input['status'],
        ':id' => $department_id
    ]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Department updated successfully'
        ]);
    } else {
        $errorInfo = $update_stmt->errorInfo();
        throw new Exception('Database update failed: ' . ($errorInfo[2] ?? 'Unknown error'));
    }

} catch (PDOException $e) {
    error_log("PDOException in update_department.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    error_log("Exception in update_department.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
?>
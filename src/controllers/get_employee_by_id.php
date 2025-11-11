<?php
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 0);
error_reporting(0);

try {
    require_once __DIR__ . '/../../config/database.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }

    $employee_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($employee_id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Employee ID is required']);
        exit;
    }

    $stmt = $pdo->prepare('
        SELECT
            e.id,
            e.first_name,
            e.last_name,
            e.birthday AS date_of_birth,
            e.email,
            e.phone_number AS primary_phone,
            e.second_phone_number AS secondary_phone,
            e.salary,
            e.address,
            e.created_at AS hire_date,
            e.department_id, 
            e.role_id,       
            d.name AS department_name,
            r.name AS role_name
        FROM employees e
        LEFT JOIN departments d ON e.department_id = d.id
        LEFT JOIN roles r ON e.role_id = r.id
        WHERE e.id = ? AND e.status <> "fired"
    ');
    $stmt->execute([$employee_id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Employee not found']);
        exit;
    }

    $response = [
        'success' => true,
        'employee' => [
            'id' => $employee['id'],
            'first_name' => $employee['first_name'] ?? '',
            'last_name' => $employee['last_name'] ?? '',
            'date_of_birth' => $employee['date_of_birth'] ?? '',
            'email' => $employee['email'] ?? '',
            'primary_phone' => $employee['primary_phone'] ?? '',
            'secondary_phone' => $employee['secondary_phone'] ?? '',
            'salary' => $employee['salary'] ?? 0,
            'address' => $employee['address'] ?? '',
            'hire_date' => $employee['hire_date'] ?? '',
            'department_id' => $employee['department_id'] ?? null,  
            'role_id' => $employee['role_id'] ?? null,             
            'department_name' => $employee['department_name'] ?? '',
            'role_name' => $employee['role_name'] ?? ''
        ]
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
?>
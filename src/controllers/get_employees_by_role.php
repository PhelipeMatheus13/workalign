<?php
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    require_once __DIR__ . '/../../config/database.php';
    

    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }

    $role_id = isset($_GET['role_id']) ? (int)$_GET['role_id'] : 0;
    if ($role_id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'role_id is required']);
        exit;
    }

    $st = $pdo->prepare('
        SELECT 
            id, 
            first_name, 
            birthday, 
            phone_number, 
            salary
        FROM employees
        WHERE role_id = ? AND status <> "fired"
        ORDER BY first_name ASC
    ');
    $st->execute([$role_id]);
    $employees = $st->fetchAll(PDO::FETCH_ASSOC);

    // Calculate age and format data.
    foreach ($employees as &$emp) {
        // Calculate age from date of birth
        $birthday = new DateTime($emp['birthday']);
        $today = new DateTime();
        $age = $today->diff($birthday)->y;
        $emp['age'] = $age;

        $emp['name'] = $emp['first_name'];
        
        $emp['salary'] = number_format(($emp['salary'] ?? 0), 2, '.', ',');
        
        // Rename phone_number to phone (to maintain compatibility with the frontend)
        $emp['phone'] = $emp['phone_number'];
        
        unset($emp['first_name'],  $emp['birthday'], $emp['phone_number']);
    }
    unset($emp);

    echo json_encode(['employees' => $employees], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
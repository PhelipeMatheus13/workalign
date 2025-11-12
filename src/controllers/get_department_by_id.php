<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Department ID is required']);
    exit;
}

$departmentId = $_GET['id'];

if (!is_numeric($departmentId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid Department ID']);
    exit;
}

try {
    $stmt = $pdo->prepare('
        SELECT 
            id,
            name,
            short_name,
            description,
            status
        FROM departments 
        WHERE id = ?
    ');
    $stmt->execute([$departmentId]);
    $department = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($department) {
        echo json_encode([
            'success' => true,
            'department' => $department
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Department not found']);
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
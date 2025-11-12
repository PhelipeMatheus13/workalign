<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Role ID is required']);
    exit;
}

$roleId = $_GET['id'];

if (!is_numeric($roleId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid Role ID']);
    exit;
}

try {
    $stmt = $pdo->prepare('
        SELECT 
            id,
            name,
            description
        FROM roles 
        WHERE id = ?
    ');
    $stmt->execute([$roleId]);
    $role = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($role) {
        echo json_encode([
            'success' => true,
            'role' => $role
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Role not found']);
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
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

    $required_fields = ['id', 'name', 'description'];
    foreach ($required_fields as $field) {
        if (!isset($input[$field]) || $input[$field] === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
            exit;
        }
    }

    $role_id = (int)$input['id'];
    if ($role_id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid role ID']);
        exit;
    }

    // Check if the role exists.
    $check_stmt = $pdo->prepare('SELECT id FROM roles WHERE id = ?');
    $check_stmt->execute([$role_id]);
    if (!$check_stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Role not found']);
        exit;
    }

    $name = trim($input['name']);
    if (empty($name)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Role name cannot be empty']);
        exit;
    }

    $description = trim($input['description']);
    if (empty($description)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Role description cannot be empty']);
        exit;
    }

    // Check if another role with the same name already exists (excluding the current one).
    $check_duplicate_stmt = $pdo->prepare('
        SELECT id FROM roles 
        WHERE name = :name AND id != :id
    ');
    $check_duplicate_stmt->execute([
        ':name' => $name,
        ':id' => $role_id
    ]);
    
    if ($duplicate = $check_duplicate_stmt->fetch()) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'A role with this name already exists']);
        exit;
    }

    $update_stmt = $pdo->prepare('
        UPDATE roles SET 
            name = :name,
            description = :description,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
    ');

    $success = $update_stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':id' => $role_id
    ]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Role updated successfully'
        ]);
    } else {
        $errorInfo = $update_stmt->errorInfo();
        throw new Exception('Database update failed: ' . ($errorInfo[2] ?? 'Unknown error'));
    }

} catch (PDOException $e) {
    error_log("PDOException in update_role.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    error_log("Exception in update_role.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}
?>
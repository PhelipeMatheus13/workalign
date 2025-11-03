<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $employee_id = $input['id'] ?? null;

        if (!$employee_id || !is_numeric($employee_id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid employee ID']);
            exit;
        }

        $query = "DELETE FROM employees WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $employee_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Employee deleted successfully'
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false, 
                    'error' => 'Employee not found'
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => 'Failed to delete employee'
            ]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        error_log("Database error in delete_employee: " . $e->getMessage());
        echo json_encode([
            'success' => false, 
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false, 
        'error' => 'Method not allowed. Only POST requests are accepted.'
    ]);
}
?>
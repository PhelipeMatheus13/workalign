<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $department_id = $input['id'] ?? null;

        if (!$department_id || !is_numeric($department_id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid department ID']);
            exit;
        }

        // Verificar se existem funcionários no departamento
        $check_employees = "SELECT COUNT(*) as employee_count FROM employees WHERE department_id = :id";
        $stmt_check = $pdo->prepare($check_employees);
        $stmt_check->bindParam(':id', $department_id, PDO::PARAM_INT);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($result['employee_count'] > 0) {
            http_response_code(409); // Conflict
            echo json_encode([
                'success' => false, 
                'error' => 'Cannot delete department with existing employees'
            ]);
            exit;
        }

        $query = "DELETE FROM departments WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $department_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Department deleted successfully'
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false, 
                    'error' => 'Department not found'
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => 'Failed to delete department'
            ]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        error_log("Database error in delete_department: " . $e->getMessage());
        echo json_encode([
            'success' => false, 
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false, 
        'error' => 'Method not allowed. Only DELETE requests are accepted.'
    ]);
}
?>
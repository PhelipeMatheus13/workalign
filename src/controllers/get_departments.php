<?php
// get_departments.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/database.php';

try {
    $stmt = $pdo->query('
        SELECT 
            d.id,
            d.name,
            d.description,
            COUNT(e.id) AS employees_count,
            COALESCE(AVG(e.salary), 0) AS avg_salary,
            COUNT(DISTINCT r.id) AS roles_count,
            COALESCE(SUM(e.salary), 0) AS monthly_budget
        FROM departments d
        LEFT JOIN roles r ON d.id = r.department_id
        LEFT JOIN employees e ON e.role_id = r.id AND e.status != "fired"
        GROUP BY d.id, d.name, d.description
        ORDER BY d.name
    ');
    
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Formatar os números
    foreach ($departments as &$dept) {
        $dept['avg_salary'] = number_format($dept['avg_salary'], 2, '.', ',');
        $dept['monthly_budget'] = number_format($dept['monthly_budget'], 2, '.', ',');
    }
    
    echo json_encode($departments, JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
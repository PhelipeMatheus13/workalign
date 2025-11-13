<?php
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    require_once __DIR__ . '/../../config/database.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }

    // Look for departments that have at least one function associated with them.
    $query = "
        SELECT DISTINCT 
            d.id AS department_id,
            d.name AS department_name,
            d.short_name AS department_short_name
        FROM departments d
        INNER JOIN roles r ON d.id = r.department_id
        WHERE r.id IS NOT NULL
        ORDER BY d.name
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // For each department, identify its functions.
    $result = [];
    foreach ($departments as $dept) {
        $rolesQuery = "
            SELECT 
                id AS role_id,
                name AS role_name
            FROM roles 
            WHERE department_id = :department_id
            ORDER BY name
        ";
        
        $rolesStmt = $pdo->prepare($rolesQuery);
        $rolesStmt->execute([':department_id' => $dept['department_id']]);
        $roles = $rolesStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Use short_name if available, otherwise use the full name.
        $displayName = !empty($dept['department_short_name']) 
            ? $dept['department_short_name'] 
            : $dept['department_name'];

        $result[] = [
            'department_id' => $dept['department_id'],
            'department_name' => $dept['department_name'],
            'department_display' => $displayName,
            'roles' => $roles
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $result
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
?>
<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(0);

try {
    // Corrigir o caminho do database.php
    require_once __DIR__ . '/../../config/database.php';
    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }

    // Buscar departamentos que tenham pelo menos uma função atrelada
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

    // Para cada departamento, buscar suas funções
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
        
        // Usar short_name se disponível, senão usar o nome completo
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
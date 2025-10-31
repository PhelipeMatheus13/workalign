<?php
header('Content-Type: application/json; charset=utf-8');

// Desativar exibição de erros para não poluir o JSON
ini_set('display_errors', 0);
error_reporting(0);

try {
    require_once __DIR__ . '/../../config/database.php';
    
    // Verificar se a conexão foi estabelecida
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

    // Calcular idade e formatar dados
    foreach ($employees as &$emp) {
        // Calcular idade a partir da data de nascimento
        $birthday = new DateTime($emp['birthday']);
        $today = new DateTime();
        $age = $today->diff($birthday)->y;
        $emp['age'] = $age;

        // Formatar nome completo
        $emp['name'] = $emp['first_name'];
        
        // Formatar salário
        $emp['salary'] = number_format(($emp['salary'] ?? 0), 2, '.', ',');
        
        // Renomear phone_number para phone (para manter compatibilidade com frontend)
        $emp['phone'] = $emp['phone_number'];
        
        // Remover campos que não serão usados no frontend
        unset($emp['first_name'],  $emp['birthday'], $emp['phone_number']);
    }
    unset($emp);

    echo json_encode(['employees' => $employees], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
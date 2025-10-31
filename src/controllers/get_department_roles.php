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

    $department_id = isset($_GET['department_id']) ? (int)$_GET['department_id'] : 0;
    if ($department_id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'department_id is required']);
        exit;
    }

    // Busca departamento
    $st = $pdo->prepare('SELECT id, name FROM departments WHERE id = ? LIMIT 1');
    $st->execute([$department_id]);
    $department = $st->fetch(PDO::FETCH_ASSOC);
    
    if (!$department) {
        http_response_code(404);
        echo json_encode(['error' => 'Department not found']);
        exit;
    }

    // Busca funções relacionadas com estatísticas básicas
    $st = $pdo->prepare('
        SELECT
            r.id,
            r.name,
            r.description,
            (SELECT COUNT(*) FROM employees e WHERE e.role_id = r.id AND e.status <> "fired") AS employees_count,
            (SELECT COALESCE(SUM(e.salary), 0) FROM employees e WHERE e.role_id = r.id AND e.status <> "fired") AS total_salary,
            (SELECT CONCAT(e.first_name, " ", e.last_name) FROM employees e WHERE e.role_id = r.id AND e.status <> "fired" ORDER BY e.salary DESC LIMIT 1) AS highest_paid_name,
            (SELECT e.salary FROM employees e WHERE e.role_id = r.id AND e.status <> "fired" ORDER BY e.salary DESC LIMIT 1) AS highest_paid_salary
        FROM roles r
        WHERE r.department_id = ?
        ORDER BY r.name ASC
    ');
    $st->execute([$department_id]);
    $roles = $st->fetchAll(PDO::FETCH_ASSOC);

    foreach ($roles as &$r) {
        $r['total_salary'] = number_format(($r['total_salary'] ?? 0), 2, '.', ',');
        $r['highest_paid_salary'] = isset($r['highest_paid_salary']) 
            ? number_format($r['highest_paid_salary'], 2, '.', ',') 
            : null;
    }
    unset($r);

    echo json_encode([
        'department' => $department,
        'roles' => $roles
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
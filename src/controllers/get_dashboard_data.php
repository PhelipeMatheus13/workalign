<?php
header('Content-Type: application/json; charset=utf-8');
// REMOVA temporariamente para debug
// ini_set('display_errors', 0);
// error_reporting(0);

// ADICIONE para ver erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    require_once __DIR__ . '/../../config/database.php';    
    if (!isset($pdo)) {
        throw new Exception('Database connection not established');
    }

    // Dados gerais
    $generalQuery = "
        SELECT 
            (SELECT COUNT(*) FROM departments WHERE status = 'active') as total_departments,
            (SELECT COUNT(*) FROM employees WHERE status = 'active') as total_employees,
            (SELECT COALESCE(AVG(salary), 0) FROM employees WHERE status = 'active') as avg_salary,
            (SELECT COALESCE(SUM(salary), 0) FROM employees WHERE status = 'active') as total_salary
    ";

    $stmt = $pdo->prepare($generalQuery);
    $stmt->execute();
    $generalData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Distribuição por departamento
    $deptQuery = "
        SELECT 
            CASE 
                WHEN d.short_name IS NOT NULL AND d.short_name != '' THEN d.short_name 
                ELSE d.name 
            END as department_name,
            COUNT(e.id) as employee_count
        FROM departments d
        LEFT JOIN employees e ON d.id = e.department_id AND e.status = 'active'
        WHERE d.status = 'active'
        GROUP BY d.id, d.name, d.short_name
        ORDER BY COUNT(e.id) DESC
    ";

    $stmt = $pdo->prepare($deptQuery);
    $stmt->execute();
    $departmentData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Próximos aniversariantes
    $birthdayQuery = "
        SELECT 
            CONCAT(e.first_name, ' ', e.last_name) as employee_name,
            e.birthday,
            CASE 
                WHEN d.short_name IS NOT NULL AND d.short_name != '' THEN d.short_name 
                ELSE d.name 
            END as department_name,
            CASE 
                WHEN DATE(CONCAT(YEAR(CURDATE()), '-', DATE_FORMAT(e.birthday, '%m-%d'))) >= CURDATE()
                THEN DATEDIFF(DATE(CONCAT(YEAR(CURDATE()), '-', DATE_FORMAT(e.birthday, '%m-%d'))), CURDATE())
                ELSE DATEDIFF(DATE(CONCAT(YEAR(CURDATE()) + 1, '-', DATE_FORMAT(e.birthday, '%m-%d'))), CURDATE())
            END as days_until_birthday
        FROM employees e
        LEFT JOIN departments d ON e.department_id = d.id
        WHERE e.status = 'active' 
          AND e.birthday IS NOT NULL
        ORDER BY 
            CASE 
                WHEN DATE(CONCAT(YEAR(CURDATE()), '-', DATE_FORMAT(e.birthday, '%m-%d'))) >= CURDATE()
                THEN DATE(CONCAT(YEAR(CURDATE()), '-', DATE_FORMAT(e.birthday, '%m-%d')))
                ELSE DATE(CONCAT(YEAR(CURDATE()) + 1, '-', DATE_FORMAT(e.birthday, '%m-%d')))
            END ASC
        LIMIT 5
    ";

    $stmt = $pdo->prepare($birthdayQuery);
    $stmt->execute();
    $birthdayData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Processar os dados
    $response = [
        'success' => true,
        'data' => [
            'general_info' => [
                'total_departments' => (int)$generalData['total_departments'],
                'total_employees' => (int)$generalData['total_employees'],
                'avg_salary' => round((float)$generalData['avg_salary'], 2),
                'total_salary' => round((float)$generalData['total_salary'], 2)
            ],
            'department_distribution' => $departmentData,
            'upcoming_birthdays' => $birthdayData
        ]
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage(),
        'debug_info' => [
            'file' => __FILE__,
            'line' => __LINE__
        ]
    ]);
}
?>
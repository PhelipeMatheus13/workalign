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

   $st = $pdo->prepare('
      SELECT
         e.id,
         e.first_name,
         e.birthday,
         e.salary,
         d.short_name AS department_short_name,
         d.name AS department_name,
         r.name AS role_name
      FROM employees e
      LEFT JOIN departments d ON e.department_id = d.id
      LEFT JOIN roles r ON e.role_id = r.id
      ORDER BY e.created_at DESC;
   ');

   $st->execute();
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

      // Verifica se existe um short_name do departamento
      if (!empty($emp['department_short_name'])) {
         $emp['department'] = $emp['department_short_name'];
      } else {
         $emp['department'] = $emp['department_name'];
      }

      $emp['role'] = $emp['role_name'];

      // Remover campos que não serão usados no frontend
      unset($emp['first_name'],  $emp['birthday'], $emp['department_short_name'], $emp['department_name'], $emp['role_name']);
   }
   unset($emp);

   echo json_encode(['employees' => $employees], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

?>
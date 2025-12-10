<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use Exception;
use PDOException;

class Departments
{
   public function listDepartments()
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare('
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

         $success = $stmt->execute();
         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

         // Format the numbers
         foreach ($departments as &$dept) {
            $dept['avg_salary'] = number_format($dept['avg_salary'], 2, '.', ',');
            $dept['monthly_budget'] = number_format($dept['monthly_budget'], 2, '.', ',');
         }
         unset($dept);

         return [
            'success' => true,
            'list_departments' => $departments
         ];
      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }

   public function getDepartmentByID($id)
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare('
            SELECT 
               id,
               name,
               short_name,
               description,
               status
            FROM departments
            WHERE id = :id
         ');

         $success = $stmt->execute([':id' => $id]);
         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         $department = $stmt->fetch(PDO::FETCH_ASSOC);

         if (!$department) {
            return [
               'success' => false,
               'error' => 'NOT_FOUND'
            ];
         }

         return [
            'success' => true,
            'department' => $department
         ];
      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }

   // This function can be implemented to list roles for a specific department.
   public function listDepartmentRoles($id)
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare('
            SELECT
                  r.id,
                  r.name,
                  r.description,
                  (SELECT COUNT(*) FROM employees e WHERE e.role_id = r.id AND e.status <> "fired") AS employees_count,
                  (SELECT COALESCE(SUM(e.salary), 0) FROM employees e WHERE e.role_id = r.id AND e.status <> "fired") AS total_salary,
                  (SELECT CONCAT(e.first_name, " ", e.last_name) FROM employees e WHERE e.role_id = r.id AND e.status <> "fired" ORDER BY e.salary DESC LIMIT 1) AS highest_paid_name,
                  (SELECT e.salary FROM employees e WHERE e.role_id = r.id AND e.status <> "fired" ORDER BY e.salary DESC LIMIT 1) AS highest_paid_salary
            FROM roles r
            WHERE r.department_id = :id
            ORDER BY r.name ASC
         ');

         $success = $stmt->execute([':id' => $id]);
         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

         foreach ($roles as &$r) {
            $r['total_salary'] = number_format(($r['total_salary'] ?? 0), 2, '.', ',');
            $r['highest_paid_salary'] = isset($r['highest_paid_salary'])
               ? number_format($r['highest_paid_salary'], 2, '.', ',')
               : null;
         }
         unset($r);

         return [
            'success' => true,
            'list_roles' => $roles
         ];
      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }

   public function getDepartmentsWithRoles()
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare('
            SELECT DISTINCT 
               d.id AS department_id,
               d.name AS department_name,
               d.short_name AS department_short_name
            FROM departments d
            INNER JOIN roles r ON d.id = r.department_id
            WHERE r.id IS NOT NULL
            ORDER BY d.name
         ');

         $success = $stmt->execute();
         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

         // For each department, identify its functions.
         $result = [];
         foreach ($departments as $dept) {
            $rolesStmt = $db->prepare('
               SELECT 
                  id AS role_id,
                  name AS role_name
               FROM roles 
               WHERE department_id = :department_id
               ORDER BY name
            ');

            $success = $rolesStmt->execute([':department_id' => $dept['department_id']]);
            if (!$success) {
               $errorInfo = $rolesStmt->errorInfo();
               return [
                  'success' => false,
                  'error' => 'DATABASE_ERROR',
                  'message' => $errorInfo[2]
               ];
            }

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

         return [
            'success' => true,
            'data' => $result
         ];
      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }


   public function createDepartment($data)
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare('
                INSERT INTO departments 
                    (name, short_name, description, status)
                VALUES 
                    (:name, :short_name, :description, :status)
            ');

         $success = $stmt->execute([
            'name' => $data['name'],
            'short_name' => $data['short_name'],
            'description' => $data['description'],
            'status' => $data['status'],
         ]);

         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         return ['success' => true];

      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }

   public function updateDepartment($id, $data)
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare('
            UPDATE departments SET 
                  name = :name,
                  short_name = :short_name,
                  description = :description,
                  status = :status,
                  updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
         ');

         $success = $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'short_name' => $data['short_name'],
            'status' => $data['status'],
            'description' => $data['description']
         ]);

         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         return ['success' => true];

      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }

   public function deleteDepartment($id)
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare('DELETE FROM departments WHERE id = ?');
         $success = $stmt->execute([$id]);

         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         if ($stmt->rowCount() === 0) {
            return [
               'success' => false,
               'error' => 'NOT_FOUND'
            ];
         }

         return ['success' => true];

      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }


   public function getTotalDepartments()
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare("
            SELECT COUNT(*) as total_departments
            FROM departments
            WHERE status = 'active'
         ");

         $success = $stmt->execute();
         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         $total = $row ? (int) $row['total_departments'] : 0;

         return [
            'success' => true,
            'total_departments' => $total
         ];
      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }

   public function getDepartmentDistribution()
   {
      try {
         $db = Database::connect();
         $stmt = $db->prepare("
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
         ");

         $success = $stmt->execute();
         if (!$success) {
            $errorInfo = $stmt->errorInfo();
            return [
               'success' => false,
               'error' => 'DATABASE_ERROR',
               'message' => $errorInfo[2]
            ];
         }

         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

         return [
            'success' => true,
            'department_distribution' => $rows // cada item tem department_name e employee_count
         ];
      } catch (PDOException $e) {
         return [
            'success' => false,
            'error' => 'DB_OPERATION_FAILED',
            'message' => $e->getMessage()
         ];
      } catch (Exception $e) {
         return [
            'success' => false,
            'error' => 'INTERNAL_ERROR',
            'message' => $e->getMessage()
         ];
      }
   }
}

<?php

namespace App\Models;

use App\Core\Database;

use Exception;
use PDOException;
use PDO;

class DepartmentRoles
{

    public function getRoleByID($id)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
                SELECT 
                    id,
                    name,
                    description
                FROM roles 
                WHERE id = ?
            ');
            $success = $stmt->execute([$id]);

            if (!$success) {
                $errorInfo = $stmt->errorInfo();
                return [
                    'success' => false,
                    'error' => 'DATABASE_ERROR',
                    'message' => $errorInfo[2]
                ];
            }

            $role = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$role) {
                return [
                    'success' => false,
                    'error' => 'NOT_FOUND',
                    'message' => 'Role not found'
                ];
            }

            return [
                'success' => true,
                'role' => $role
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
    public function listDepartmentRoles($departmentID)
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
            WHERE r.department_id = :department_id
            ORDER BY r.name ASC
         ');

            $success = $stmt->execute([':department_id' => $departmentID]);
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

    public function createDepartmentRole($data)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
                INSERT INTO roles 
                    (name, description, department_id)
                VALUES 
                    (:name, :description, :department_id)
            ');

            $success = $stmt->execute([
                'name' => $data['name'],
                'description' => $data['description'],
                'department_id' => $data['department_id']
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

    public function updateDepartmentRole($id, $data)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
                UPDATE roles SET 
                    name = :name, 
                    description = :description,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id
            ');

            $success = $stmt->execute([
                'name' => $data['name'],
                'description' => $data['description'],
                'id' => $id
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

    public function deleteDepartmentRole($id)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('DELETE FROM roles WHERE id = ?');
            $success = $stmt->execute([$id]);

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
}
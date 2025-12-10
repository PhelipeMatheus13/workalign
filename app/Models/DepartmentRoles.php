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
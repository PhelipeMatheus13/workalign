<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use DateTime;
use Exception;
use PDOException;

class Employees
{
    public function listEmployees()
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
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

            $success = $stmt->execute();

            if (!$success) {
                $errorInfo = $stmt->errorInfo();
                return [
                    'success' => false,
                    'error' => 'DATABASE_ERROR',
                    'message' => $errorInfo[2]
                ];
            }

            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Calculate age and format data.
            foreach ($employees as &$emp) {
                // Calculate age from date of birth
                $birthday = new DateTime($emp['birthday']);
                $today = new DateTime();
                $age = $today->diff($birthday)->y;
                $emp['age'] = $age;

                $emp['name'] = $emp['first_name'];

                $emp['salary'] = number_format(($emp['salary'] ?? 0), 2, '.', ',');

                // Checks if a department short_name exists.
                $emp['department'] = !empty($emp['department_short_name'])
                    ? $emp['department_short_name']
                    : $emp['department_name'];

                $emp['role'] = $emp['role_name'];

                unset($emp['first_name'], $emp['birthday'], $emp['department_short_name'], $emp['department_name'], $emp['role_name']);
            }
            unset($emp);

            return [
                'success' => true,
                'list_employees' => $employees
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

    public function listEmployeesByRole($roleId)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
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
            $success = $stmt->execute([$roleId]);

            if (!$success) {
                $errorInfo = $stmt->errorInfo();
                return [
                    'success' => false,
                    'error' => 'DATABASE_ERROR',
                    'message' => $errorInfo[2]
                ];
            }

            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Calculate age and format data.
            foreach ($employees as &$emp) {
                // Calculate age from date of birth
                $birthday = new DateTime($emp['birthday']);
                $today = new DateTime();
                $age = $today->diff($birthday)->y;
                $emp['age'] = $age;

                $emp['name'] = $emp['first_name'];

                $emp['salary'] = number_format(($emp['salary'] ?? 0), 2, '.', ',');

                unset($emp['first_name'], $emp['birthday']);
            }
            unset($emp);

            return [
                'success' => true,
                'list_employees' => $employees
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

    public function getEmployeeByID($id)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
                SELECT
                    e.id,
                    e.first_name,
                    e.last_name,
                    e.birthday, 
                    e.email,
                    e.phone_number,
                    e.second_phone_number,
                    e.salary,
                    e.address,
                    e.created_at AS hire_date,
                    e.department_id, 
                    e.role_id,       
                    d.name AS department_name,
                    r.name AS role_name
                FROM employees e
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN roles r ON e.role_id = r.id
                WHERE e.id = ? AND e.status <> \'fired\'
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

            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$employee) {
                return [
                    'success' => false,
                    'error' => 'NOT_FOUND',
                    'message' => 'Employee not found'
                ];
            }

            return [
                'success' => true,
                'employee' => $employee
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



    public function createEmployee($data)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
                INSERT INTO employees 
                    (first_name, last_name, birthday, email, phone_number, second_phone_number, address, salary, department_id, role_id)
                VALUES 
                    (:first_name, :last_name, :birthday, :email, :phone_number, :second_phone_number, :address, :salary, :department_id, :role_id)
            ');

            $success = $stmt->execute([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'birthday' => $data['birthday'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'second_phone_number' => $data['second_phone_number'],
                'address' => $data['address'],
                'salary' => $data['salary'],
                'department_id' => $data['department_id'],
                'role_id' => $data['role_id']
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


    public function updateEmployee($id, $data)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('
                UPDATE employees SET 
                    first_name = :first_name,
                    last_name = :last_name,
                    birthday = :birthday,
                    email = :email,
                    phone_number = :phone_number,
                    second_phone_number = :second_phone_number,
                    salary = :salary,
                    address = :address,
                    department_id = :department_id,
                    role_id = :role_id,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id
            ');

            $success = $stmt->execute([
                'id' => $id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'birthday' => $data['birthday'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'second_phone_number' => $data['second_phone_number'],
                'salary' => $data['salary'],
                'address' => $data['address'],
                'department_id' => $data['department_id'],
                'role_id' => $data['role_id']
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

    public function deleteEmployee($id)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('DELETE FROM employees WHERE id = ?');
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

    public function getTotalEmployees()
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT COUNT(*) as total_employees
                FROM employees
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
            $total = $row ? (int) $row['total_employees'] : 0;

            return [
                'success' => true,
                'total_employees' => $total
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

    public function getAvgSalary()
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT COALESCE(AVG(salary), 0) as avg_salary
                FROM employees
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
            $avg = $row ? (float) $row['avg_salary'] : 0.0;

            return [
                'success' => true,
                'avg_salary' => $avg
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

    public function getTotalSalary()
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT COALESCE(SUM(salary), 0) as total_salary
                FROM employees
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
            $sum = $row ? (float) $row['total_salary'] : 0.0;

            return [
                'success' => true,
                'total_salary' => $sum
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

    public function getUpcomingBirthdays($limit = 5)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
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
                LIMIT :limit
            ");

            // bind limit as integer
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

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
                'upcoming_birthdays' => $rows // each item has employee_name, birthday, department_name, days_until_birthday
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
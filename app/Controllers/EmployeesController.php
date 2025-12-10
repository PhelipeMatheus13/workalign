<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Employees;

class EmployeesController
{
    public function index()
    {
        // Render the employees view
        return Response::view('employees/index');
    }

    public function list()
    {
        $model = new Employees();
        $result = $model->listEmployees();

        if (!$result['success']) {
            $errorMap = [
                'DATABASE_ERROR' => ['message' => $result['message'], 'code' => 500],
                'DB_OPERATION_FAILED' => ['message' => 'Database operation failed. Please try again later.', 'code' => 500],
                'INTERNAL_ERROR' => ['message' => 'Internal server error. Please try again later.', 'code' => 500]
            ];

            $errorConfig = $errorMap[$result['error']] ?? ['message' => 'An error occurred', 'code' => 500];

            return Response::json([
                'success' => false,
                'error' => $result['message'],
                'message' => $errorConfig['message']
            ], $errorConfig['code']);
        }

        return Response::json([
            'success' => true,
            'data' => $result['list_employees']
        ]);
    }

    public function listByRole(Request $request)
    {
        $role_id = $request->input('role_id');
        // Validate role_id
        if (!$role_id || !is_numeric($role_id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid role ID provided.'
            ], 400);
        }

        $model = new Employees();
        $result = $model->listEmployeesByRole($role_id);

        if (!$result['success']) {
            $errorMap = [
                'DATABASE_ERROR' => ['message' => $result['message'], 'code' => 500],
                'DB_OPERATION_FAILED' => ['message' => 'Database operation failed. Please try again later.', 'code' => 500],
                'INTERNAL_ERROR' => ['message' => 'Internal server error. Please try again later.', 'code' => 500]
            ];

            $errorConfig = $errorMap[$result['error']] ?? ['message' => 'An error occurred', 'code' => 500];

            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'message' => $errorConfig['message']
            ], $errorConfig['code']);
        }

        return Response::json([
            'success' => true,
            'data' => $result['list_employees']
        ]);
    }

    public function show()
    {
        return Response::view('employees/show');
    }


    public function get(Request $request)
    {
        $id = $request->input('id');
        // Validate ID
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid employee ID provided.'
            ], 400);
        }

        $model = new Employees();
        $result = $model->getEmployeeByID($id);

        if (!$result['success']) {
            $errorMap = [
                'DATABASE_ERROR' => ['message' => $result['message'], 'code' => 500],
                'DB_OPERATION_FAILED' => ['message' => 'Database operation failed. Please try again later.', 'code' => 500],
                'INTERNAL_ERROR' => ['message' => 'Internal server error. Please try again later.', 'code' => 500],
                'NOT_FOUND' => ["message' => 'Employee id=$id not found.", 'code' => 404]
            ];

            $errorConfig = $errorMap[$result['error']] ?? ['message' => 'An error occurred', 'code' => 500];

            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'message' => $errorConfig['message']
            ], $errorConfig['code']);
        }

        return Response::json([
            'success' => true,
            'data' => $result['employee']
        ]);
    }

    public function createForm()
    {
        return Response::view('employees/create');
    }

    private function renderResponse($title, $message, $type, $options = [])
    {
        $defaultOptions = [
            'redirectUrl' => null,
            'redirectTime' => 3000,
            'showBackButton' => true,
            'backUrl' => null,
            'details' => null,
            'primaryButton' => null
        ];

        $options = array_merge($defaultOptions, $options);

        $data = [
            'menuActive' => 'employees', 
            'pageTitle' => $title,
            'message' => $message,
            'type' => $type,
            'redirectUrl' => $options['redirectUrl'],
            'redirectTime' => $options['redirectTime'],
            'showBackButton' => $options['showBackButton'],
            'backUrl' => $options['backUrl'] ?? 'javascript:history.back()',
            'details' => $options['details'],
            'primaryButton' => $options['primaryButton']
        ];

        return Response::view('layouts/response_form', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birthday' => $request->input('birthday'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'second_phone_number' => $request->input('second_phone_number'),
            'address' => $request->input('address'),
            'salary' => $request->input('salary'),
            'department_id' => $request->input('department_id'),
            'role_id' => $request->input('role_id'),
        ];

        // Validate required fields
        $requiredFields = [
            'first_name' => 'First name is required',
            'last_name' => 'Last name is required',
            'birthday' => 'Birthday is required',
            'email' => 'Email is required',
            'phone_number' => 'Primary phone is required',
            'address' => 'Address is required',
            'salary' => 'Salary is required',
            'department_id' => 'Department ID is required',
            'role_id' => 'Role ID is required'
        ];

        $errorMessages = [];
        foreach ($requiredFields as $fields => $message) {
            if (empty($data[$fields])) {
                $errorMessages[] = $message;
            }
        }

        if (!empty($errorMessages)) {
            $errorMessage = implode('<br>', $errorMessages);

            return $this->renderResponse(
                'Validation Error',
                $errorMessage,
                'error',
                [
                    'showBackButton' => true,
                    'backUrl' => 'employees/create'
                ]
            );
        }

        // Process second_phone_number
        if (array_key_exists('second_phone_number', $data)) {
            $value = trim($data['second_phone_number']);
            // If an empty string is received, store it as null.
            if ($value === '') {
                $data['second_phone_number'] = null;
            }
        }

        $model = new Employees();
        $result = $model->createEmployee($data);

        if (!$result['success']) {
            $errorMap = [
                'DATABASE_ERROR' => ['message' => $result['message'], 'code' => 500],
                'DB_OPERATION_FAILED' => ['message' => 'Database operation failed. Please try again later.', 'code' => 500],
                'INTERNAL_ERROR' => ['message' => 'Internal server error. Please try again later.', 'code' => 500]
            ];

            $errorConfig = $errorMap[$result['error']] ?? ['message' => 'An error occurred', 'code' => 500];

            return $this->renderResponse(
                'Registration Error',
                $errorConfig['message'],
                'error',
                [
                    'showBackButton' => true,
                    'backUrl' => 'employees/create'
                ]
            );
        }

        $employeeName = $data['first_name'] . ' ' . $data['last_name'];
        return $this->renderResponse(
            'Employee Created',
            "Employee <strong>$employeeName</strong> has been successfully registered!",
            'success',
            [
                'redirectUrl' => 'employees',
                'redirectTime' => 5000
            ]
        );
    }

    public function updateForm()
    {
        return Response::view('employees/update');
    }


    public function update(Request $request)
    {
        $employee_id = $request->input('id');
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birthday' => $request->input('birthday'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'second_phone_number' => $request->input('second_phone_number'),
            'salary' => $request->input('salary'),
            'address' => $request->input('address'),
            'department_id' => $request->input('department_id'),
            'role_id' => $request->input('role_id'),
        ];

        // Validate required fields
        $requiredFields = [
            'first_name' => 'First name is required',
            'last_name' => 'Last name is required',
            'birthday' => 'Birthday is required',
            'email' => 'Email is required',
            'phone_number' => 'Primary phone is required',
            'address' => 'Address is required',
            'salary' => 'Salary is required',
            'department_id' => 'Department ID is required',
            'role_id' => 'Role ID is required'
        ];

        $errorMessages = [];
        foreach ($requiredFields as $field => $message) {
            if (empty($data[$field])) {
                $errorMessages[] = $message;
            }
        }

        if (!empty($errorMessages)) {
            $errorMessage = implode('<br>', $errorMessages);
            return $this->renderResponse(
                'Validation Error',
                $errorMessage,
                'error',
                [
                    'showBackButton' => true,
                    'backUrl' => 'employees/update?id=' . $employee_id
                ]
            );
        }

        // Process second_phone_number
        if (array_key_exists('second_phone_number', $data)) {
            $value = trim($data['second_phone_number']);
            if ($value === '') {
                $data['second_phone_number'] = null;
            }
        }

        $model = new Employees();
        $result = $model->updateEmployee($employee_id, $data);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => 'Employee not found.', 'code' => 404],
                'DATABASE_ERROR' => ['message' => $result['message'], 'code' => 500],
                'DB_OPERATION_FAILED' => ['message' => 'Database operation failed. Please try again later.', 'code' => 500],
                'INTERNAL_ERROR' => ['message' => 'Internal server error. Please try again later.', 'code' => 500]
            ];

            $errorConfig = $errorMap[$result['error']] ?? ['message' => 'An error occurred', 'code' => 500];

            return $this->renderResponse(
                'Update Error',
                $errorConfig['message'],
                'error',
                [
                    'showBackButton' => true,
                    'backUrl' => 'employees/update?id=' . $employee_id
                ]
            );
        }

        $employeeName = $data['first_name'] . ' ' . $data['last_name'];
        return $this->renderResponse(
            'Employee Updated',
            "Employee <strong>$employeeName</strong> has been successfully updated!",
            'success',
            [
                'redirectUrl' => 'employees/show?id=' . $employee_id,
                'redirectTime' => 2000,
            ]
        );
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        // Validate ID
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid employee ID provided.'
            ], 400);
        }

        $model = new Employees();
        $result = $model->deleteEmployee($id);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => 'Employee not found.', 'code' => 404],
                'DATABASE_ERROR' => ['message' => $result['message'], 'code' => 500], 
                'DB_OPERATION_FAILED' => ['message' => 'Database operation failed. Please try again later.', 'code' => 500],
                'INTERNAL_ERROR' => ['message' => 'Internal server error. Please try again later.', 'code' => 500]
            ];

            $errorConfig = $errorMap[$result['error']] ?? ['message' => 'An error occurred', 'code' => 500];

            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'message' => $errorConfig['message']
            ], $errorConfig['code']);
        }

        return Response::json([
            'success' => true,
            'message' => 'Employee successfully removed.'
        ]);
    }
}

<?php

namespace App\Controllers;

use App\Core\ErrorMapper; 
use App\Core\Request;
use App\Core\Response;
use App\Models\Employees;

class EmployeesController
{
    public function index()
    {
        return Response::view('employees/index');
    }

    public function list()
    {
        $model = new Employees();
        $result = $model->listEmployees();

        if (!$result['success']) {
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
        }

        return Response::json([
            'success' => true,
            'data' => $result['list_employees']
        ]);
    }

    public function listByRole(Request $request)
    {
        $role_id = $request->input('role_id');
        if (!$role_id || !is_numeric($role_id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid role ID provided.',
                'friendly_message' => 'The provided role ID is invalid.'
            ], 400);
        }

        $model = new Employees();
        $result = $model->listEmployeesByRole($role_id);

        if (!$result['success']) {
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
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
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid employee ID provided.',
                'friendly_message' => 'The provided employee ID is invalid.'
            ], 400);
        }

        $model = new Employees();
        $result = $model->getEmployeeByID($id);

        if (!$result['success']) {
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
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
            return $this->renderResponse(
                'Registration Error',
                $result['message'],
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
                'backUrl' => 'employees',
                'redirectTime' => 3000
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
            return Response::JSON([
                'success' => false,
                'error' => 'VALIDATION_ERROR',
                'error_message' => $errorMessage,
                'friendly_message' => 'Please fill in all required fields.'
            ], 400);
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
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
        }

        $employeeName = $data['first_name'] . ' ' . $data['last_name'];
        return Response::json([
            'success' => true,
            'message' => "Employee $employeeName has been successfully updated!"
        ]); 
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
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
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
        }

        return Response::json([
            'success' => true,
            'message' => 'Employee successfully removed.'
        ]);
    }
}

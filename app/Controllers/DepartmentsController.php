<?php

namespace App\Controllers;

use App\Core\ErrorMapper;
use App\Core\Response;
use App\Models\Departments;
use App\Core\Request;

class DepartmentsController
{
    public function index()
    {
        return Response::view(template: 'departments/index');
    }

    public function list()
    {
        $model = new Departments();
        $result = $model->listDepartments();

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
            'data' => $result['list_departments']
        ]);
    }

    public function show()
    {
        return Response::view(template: 'departments/show');
    }

    public function listDepartmentsWithRoles()
    {
        $model = new Departments();
        $result = $model->getDepartmentsWithRoles();

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
            'data' => $result['departments_with_roles']
        ]);
    }


    public function get(Request $request)
    {
        $id = $request->input('id');
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'error_message' => "Invalid department ID: $id.",
                'friendly_message' => 'The provided department_id is invalid.'
            ], 400);
        }

        $model = new Departments();
        $result = $model->getDepartmentByID($id);

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
            'data' => $result['department']
        ]);
    }


    public function createForm()
    {
        return Response::view(template: 'departments/create');
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
            'menuActive' => 'departments',
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
            'name' => $request->input('name'),
            'short_name' => $request->input('short_name'),
            'description' => $request->input('description'),
            'status' => $request->input('status')
        ];

        $requiredFields = [
            'name' => 'Department name is required.',
            'description' => 'Department description is required.',
            'status' => 'Department status is required.'
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
                    'backUrl' => 'departments/create'
                ]
            );
        }

        $model = new Departments();
        $result = $model->createDepartment($data);

        if (!$result['success']) {
            return $this->renderResponse(
                'Registration Error',
                $result['message'],
                'error',
                [
                    'showBackButton' => true,
                    'backUrl' => 'departments/create'
                ]
            );
        }

        $departmentName = $data['name'];
        return $this->renderResponse(
            'Department Created',
            "Department <strong>$departmentName</strong> has been successfully registered!",
            'success',
            [
                'redirectUrl' => 'departments',
                'redirectTime' => 2000
            ]
        );
    }

    public function updateForm()
    {
        return Response::view('departments/update');
    }

    public function update(Request $request)
    {
        $departmentID = $request->input('id');
        $data = [
            'name' => $request->input('name'),
            'short_name' => $request->input('short_name'),
            'status' => $request->input('status'),
            'description' => $request->input('description')
        ];

        // Validate required fields
        $requiredFields = [
            'name' => 'Name is required',
            'status' => 'Status is required',
            'description' => 'Description is required'
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

        $model = new Departments();
        $result = $model->updateDepartment($departmentID, $data);

        if (!$result['success']) {
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
        }

        $departmentName = $data['name'];
        return Response::json([
            'success' => true,
            'message' => "Department $departmentName successfully updated."
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'error_message' => "Invalid department ID: $id.",
                'friendly_message' => 'The provided department ID is invalid.'
            ], 400);
        }

        $model = new Departments();
        $result = $model->deleteDepartment($id);

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
            'message' => 'Department successfully removed.'
        ]);
    }
}
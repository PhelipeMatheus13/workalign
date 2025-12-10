<?php

namespace App\Controllers;

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
            'data' => $result['list_departments']
        ]);
    }

    public function show()
    {
        return Response::view(template: 'departments/show');
    }

    public function listRoles(Request $request)
    {
        $id = $request->input('id');
        // Validate ID
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid department ID provided.'
            ], 400);
        }

        $model = new Departments();
        $result = $model->listDepartmentRoles($id);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => "Department id=$id not found.", 'code' => 404],
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
            'data' => $result['list_roles']
        ]);
    }


    public function listWithRoles()
    {
        $model = new Departments();
        $result = $model->getDepartmentsWithRoles();

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
            'data' => $result['data']
        ]);
    }

    public function get(Request $request)
    {
        $id = $request->input('id');
        // Validate ID
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid department ID provided.'
            ], 400);
        }

        $model = new Departments();
        $result = $model->getDepartmentByID($id);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => "Department id=$id not found.", 'code' => 404],
                'DATABASE_ERROR' => ['message' => $result['message'], 'code' => 500],
                'DB_OPERATION_FAILED' => ['message' => 'Database operation failed. Please try again later.', 'code' => 500],
                'INTERNAL_ERROR' => ['message' => 'Internal server error. Please try again later.', 'code' => 500]            ];

            $errorConfig = $errorMap[$result['error']] ?? ['message' => 'An error occurred', 'code' => 500];

            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'message' => $errorConfig['message']
            ], $errorConfig['code']);
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
        $department_id = $request->input('id');
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
            return $this->renderResponse(
                'Validation Error',
                $errorMessage,
                'error',
                [
                    'showBackButton' => true,
                    'backUrl' => 'departments/update?id=' . $department_id
                ]
            );
        }

        $model = new Departments();
        $result = $model->updateDepartment($department_id, $data);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => "Department id=$department_id not found.", 'code' => 404],
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
                    'backUrl' => 'departments/update?id=' . $department_id
                ]
            );
        }

        $departmentName = $data['name'];
        return $this->renderResponse(
            'Department Updated',
            "Department <strong>$departmentName</strong> has been successfully updated!",
            'success',
            [
                'redirectUrl' => 'departments',
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
                'message' => 'Invalid department ID provided.'
            ], 400);
        }

        $model = new Departments();
        $result = $model->deleteDepartment($id);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => 'Department not found.', 'code' => 404],
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
            'message' => 'Department successfully removed.'
        ]);
    }
}
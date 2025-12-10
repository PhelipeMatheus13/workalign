<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Request;
use App\Models\DepartmentRoles;


class DepartmentRolesController
{
    public function get(Request $request)
    {
        $id = $request->input('id');
        // Validate ID
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid role ID provided.'
            ], 400);
        }

        $model = new DepartmentRoles();
        $result = $model->getRoleByID($id);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => "Role id=$id not found.", 'code' => 404],
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
            'data' => $result['role']
        ]);
    }

    public function createForm()
    {
        return Response::view(template: 'departments/roles/create');
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
            'description' => $request->input('description'),
            'department_id' => $request->input('department_id')
        ];

        $requiredFields = [
            'name' => 'Role name is required.',
            'description' => 'Role description is required.',
            'department_id' => 'Department ID is required.'
        ];

        $errorMessages = [];
        foreach ($requiredFields as $fields => $message) {
            if (empty($data[$fields])) {
                $errorMessages[] = $message;
            }
        }

        $departmentId = $data['department_id'];
        if (!empty($errorMessages)) {
            $errorMessage = implode('<br>', $errorMessages);

            return $this->renderResponse(
                'Validation Error',
                $errorMessage,
                'error',
                [
                    'showBackButton' => true,
                    'backUrl' => "departments/roles/create?department_id=$departmentId"
                ]
            );
        }

        $model = new DepartmentRoles();
        $result = $model->createDepartmentRole($data);

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
                    'backUrl' => "departments/roles/create?department_id=$departmentId"
                ]
            );
        }

        $roleName = $data['name'];
        return $this->renderResponse(
            'Department Created',
            "Department role <strong>$roleName</strong> has been successfully registered!",
            'success',
            [
                'redirectUrl' => "departments/show?id=$departmentId",
                'redirectTime' => 2000
            ]
        );
    }

    public function updateForm()
    {
        return Response::view(template: 'departments/roles/update');
    }

    public function update(Request $request)
    {
        $role_id = $request->input('id');
        $department_id = $request->input('department_id');
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ];

        // Validate required fields
        $requiredFields = [
            'name' => 'Name is required',
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
                    'backUrl' => "departments/roles/update?id=$role_id&department_id=$department_id"
                ]
            );
        }

        $model = new DepartmentRoles();
        $result = $model->updateDepartmentRole($role_id, $data);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => "Role id=$role_id not found.", 'code' => 404],
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
                    'backUrl' => "departments/roles/update?id=$role_id&department_id=$department_id"
                ]
            );
        }

        $departmentName = $data['name'];
        return $this->renderResponse(
            'Department Updated',
            "Department <strong>$departmentName</strong> has been successfully updated!",
            'success',
            [
                'redirectUrl' => "departments/show?id=$department_id",
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
                'message' => 'Invalid Role ID provided.'
            ], 400);
        }

        $model = new DepartmentRoles();
        $result = $model->deleteDepartmentRole($id);

        if (!$result['success']) {
            $errorMap = [
                'NOT_FOUND' => ['message' => "Role id=$id not found.", 'code' => 404],
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
            'message' => 'Role successfully removed.'
        ]);
    }
}
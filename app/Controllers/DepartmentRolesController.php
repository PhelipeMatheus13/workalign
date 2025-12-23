<?php

namespace App\Controllers;

use App\Core\ErrorMapper;
use App\Core\Response;
use App\Core\Request;
use App\Models\DepartmentRoles;
use App\Services\DepartmentRolesService;
use App\Models\Departments;



class DepartmentRolesController
{

    public function listRoles(Request $request)
    {
        $departmentID = $request->input('department_id');
        if (!$departmentID || !is_numeric($departmentID)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid department ID provided.'
            ], 400);
        }

        $model = new DepartmentRoles();
        $result = $model->listDepartmentRoles($departmentID);

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
            'data' => $result['list_roles']
        ]);
    }

    public function get(Request $request)
    {
        $id = $request->input('id');
        if (!$id || !is_numeric($id)) {
            return Response::json([
                'success' => false,
                'error' => 'INVALID_INPUT',
                'message' => 'Invalid role_id provided.',
                'friendly_message' => 'Please provide a valid role_id.'
            ], 400);
        }

        $model = new DepartmentRoles();
        $result = $model->getRoleByID($id);

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
            return $this->renderResponse(
                'Registration Error',
                $result['message'],
                'error',
                [
                    'redirectTime' => 5000,
                    'showBackButton' => true,
                    'backUrl' => "departments/roles/create?department_id=$departmentId"
                ]
            );
        }

        // We need the department name to redirect correctly.
        $service = new DepartmentRolesService(new Departments());
        $result = $service->getDepartmentNameByID($departmentId);
        if (!$result['success']) {
            return $this->renderResponse(
                'Registration Error',
                $result['message'],
                'error',
                [
                    'redirectTime' => 5000,
                    'showBackButton' => true,
                    'backUrl' => "departments/roles/create?department_id=$departmentId"
                ]
            );
        }

        $departmentName = $result['department_name'];
        $roleName = $data['name'];
        return $this->renderResponse(
            'Department Created',
            "Department role <strong>$roleName</strong> has been successfully registered!",
            'success',
            [
                'redirectUrl' => "departments/show?id=$departmentId&name=$departmentName", // ID & Name
                'backUrl' => "departments/show?id=$departmentId&name=$departmentName",
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
        $roleID = $request->input('id');
        $departmentID = $request->input('department_id');
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
            return Response::json([
                'success' => false,
                'error' => 'VALIDATION_ERROR',
                'message' => $errorMessage,
                'friendly_message' => 'Please fill in all required fields.'
            ], 400);
        }

        $model = new DepartmentRoles();
        $result = $model->updateDepartmentRole($roleID, $data);

        if (!$result['success']) {
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
        }

        // We need the department name to redirect correctly.
        $service = new DepartmentRolesService(new Departments());
        $result = $service->getDepartmentNameByID($departmentID);
        if (!$result['success']) {
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
        }

        $departmentName = $result['department_name'];
        return Response::json([
            'success' => true,
            'message' => 'Role successfully updated.',
            'data' => [
                'redirect_url' => "departments/show?id=$departmentID&name=$departmentName"
            ]
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

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
            return Response::json([
                'success' => false,
                'error' => $result['error'],
                'error_message' => $result['message'],
                'friendly_message' => ErrorMapper::getFriendlyMessage($result['error'])
            ], ErrorMapper::getStatusCode($result['error']));
        }

        return Response::json([
            'success' => true,
            'message' => 'Role successfully removed.'
        ]);
    }
}
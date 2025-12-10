<?php

namespace App\Controllers;

use App\Core\ErrorMapper;
use App\Core\Response;
use App\Services\DashboardService;
use App\Models\Employees;
use App\Models\Departments;



class DashboardController
{
    public function index()
    {
        return Response::view(template: 'dashboard/index');
    }

    public function getDashboardData()
    {
        $service = new DashboardService(
            new Employees(),
            new Departments()
        );
        $result = $service->getDashboardData();

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
            'data' => $result['data']
        ]);
    }
}
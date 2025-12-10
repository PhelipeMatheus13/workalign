<?php

namespace App\Services;

use App\Models\Employees;
use App\Models\Departments;

class DashboardService
{
   private $employeesModel;
   private $departmentsModel;

   public function __construct(
      Employees $employeesModel,
      Departments $departmentsModel
   ) {
      $this->employeesModel = $employeesModel;
      $this->departmentsModel = $departmentsModel;
   }

   public function getDashboardData(): array
   {
      try {
         $totalDepartments = $this->departmentsModel->getTotalDepartments();
         if (!$totalDepartments['success']) {
            return $totalDepartments;
         }

         $totalEmployees = $this->employeesModel->getTotalEmployees();
         if (!$totalEmployees['success']) {
            return $totalEmployees;
         }

         $avgSalary = $this->employeesModel->getAvgSalary();
         if (!$avgSalary['success']) {
            return $avgSalary;
         }

         $totalSalary = $this->employeesModel->getTotalSalary();
         if (!$totalSalary['success']) {
            return $totalSalary;
         }

         $departmentDistribution = $this->departmentsModel->getDepartmentDistribution();
         if (!$departmentDistribution['success']) {
            return $departmentDistribution;
         }

         $upcomingBirthdays = $this->employeesModel->getUpcomingBirthdays();
         if (!$upcomingBirthdays['success']) {
            return $upcomingBirthdays;
         }

         return [
            'success' => true,
            'data' => [
               'general_info' => [
                  'total_departments' => (int) ($totalDepartments['total_departments'] ?? 0),
                  'total_employees' => (int) ($totalEmployees['total_employees'] ?? 0),
                  'average_salary' => round((float) ($avgSalary['avg_salary'] ?? 0), 2),
                  'total_salary' => round((float) ($totalSalary['total_salary'] ?? 0), 2)
               ],
               'department_distribution' => $departmentDistribution['department_distribution'] ?? [],
               'upcoming_birthdays' => $upcomingBirthdays['upcoming_birthdays'] ?? []
            ]
         ];
      } catch (\Exception $e) {
         return [
            'success' => false,
            'error' => 'SERVICE_ERROR',
            'message' => 'Error fetching dashboard data: ' . $e->getMessage()
         ];
      }
   }
}
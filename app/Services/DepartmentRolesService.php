<?php

namespace App\Services;
use App\Models\Departments;

class DepartmentRolesService
{
   private $departmentsModel;

   public function __construct(
      Departments $departmentsModel
   ) {
      $this->departmentsModel = $departmentsModel;
   }

   public function getDepartmentNameByID($id) {
      return $this->departmentsModel->getNameByID($id);
   }
}
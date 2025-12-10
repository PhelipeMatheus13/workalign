<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Response;

$router = new Router();

// employees/views 
$router->add('GET', '/employees', 'EmployeesController@index');
$router->add('GET', '/employees/show', 'EmployeesController@show');
$router->add('GET', '/employees/create', 'EmployeesController@createForm');
$router->add('GET', '/employees/update', 'EmployeesController@updateForm');
// employees/controllers
$router->add('GET', '/employees/get', 'EmployeesController@get');
$router->add('GET', '/employees/list', 'EmployeesController@list');
$router->add('GET', '/employees/list-by-role', 'EmployeesController@listByRole');
$router->add('POST', '/employees/create', 'EmployeesController@create');
$router->add('PUT', '/employees/update', 'EmployeesController@update');
$router->add('DELETE', '/employees/delete', 'EmployeesController@delete');

// departments/views 
$router->add('GET', '/departments', 'DepartmentsController@index');
$router->add('GET', '/departments/create', 'DepartmentsController@createForm');
$router->add('GET', '/departments/update', 'DepartmentsController@updateForm');
$router->add('GET', '/departments/show', 'DepartmentsController@show');

// departments/controllers
$router->add('GET', '/departments/with-roles', 'DepartmentsController@listWithRoles');
$router->add('GET', '/departments/list', 'DepartmentsController@list');
$router->add('GET', '/departments/roles/list', 'DepartmentsController@listRoles');
$router->add('GET', '/departments/get', 'DepartmentsController@get');
$router->add('POST', '/departments/create', 'DepartmentsController@create');
$router->add('PUT', '/departments/update', 'DepartmentsController@update');
$router->add('DELETE', '/departments/delete', 'DepartmentsController@delete');

// departments/roles/views
$router->add('GET', '/departments/roles/create', 'DepartmentRolesController@createForm');
$router->add('GET', '/departments/roles/update', 'DepartmentRolesController@updateForm');
// departments/roles/controllers
$router->add('POST', '/departments/roles/create', 'DepartmentRolesController@create');
$router->add('GET', '/departments/roles/get', 'DepartmentRolesController@get');
$router->add('PUT', '/departments/roles/update', 'DepartmentRolesController@update');
$router->add('DELETE', '/departments/roles/delete', 'DepartmentRolesController@delete');

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

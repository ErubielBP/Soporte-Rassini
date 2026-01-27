<?php

use App\Controllers\Login;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('Panel/index', 'Panel::index', ['filter' => 'auth']);


// Login
$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

//Crud empleados
$routes->group('empleado', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Empleado::index');
    $routes->post('store', 'Empleado::store');
    $routes->get('edit/(:num)', 'Empleado::edit/$1');
    $routes->post('update/(:num)', 'Empleado::update/$1');
    $routes->post('delete/(:num)', 'Empleado::delete/$1');
});
$routes->get('empleado/buscar', 'Empleado::buscar');


//crud equipos
$routes->group('equipos', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'EquipoComputo::index');
    $routes->post('guardar', 'EquipoComputo::guardar');
    $routes->post('actualizar/(:num)', 'EquipoComputo::actualizar/$1');
    $routes->post('eliminar/(:num)', 'EquipoComputo::eliminar/$1');
});
$routes->get('equipos/buscar', 'EquipoComputo::buscar');


//equipo_usuario 

$routes->group('usuario-equipo', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'UsuarioEquipo::index');
    $routes->get('buscar', 'UsuarioEquipo::buscar');
    $routes->post('guardar', 'UsuarioEquipo::guardar');
    $routes->post('actualizar/(:num)', 'UsuarioEquipo::actualizar/$1');
    $routes->post('eliminar/(:num)', 'UsuarioEquipo::eliminar/$1');
});

//mantenimientos
$routes->group('mantenimientos', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Mantenimientos::index');
    $routes->get('buscar', 'Mantenimientos::buscar');
    $routes->post('guardar', 'Mantenimientos::guardar');
    $routes->post('actualizar/(:num)', 'Mantenimientos::actualizar/$1');
    $routes->post('eliminar/(:num)', 'Mantenimientos::eliminar/$1');
});





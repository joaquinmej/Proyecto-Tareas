<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Archivar Controller
$routes->get('/archivar','Archivar::index');

// CrearTarea Controller
$routes->get('/creartarea', 'CrearTarea::index');
$routes->post('/creartarea/guardar', 'CrearTarea::guardar');
$routes->get('/creartarea/crearsub/(:num)', 'CrearTarea::crearsub/$1');
$routes->post('/creartarea/guardarsub', 'CrearTarea::guardarsub');

// Ejemplo Controller
$routes->get('/ejemplo', 'Ejemplo::index');

// Inicio Controller
$routes->get('/', 'Inicio::index');
$routes->get('/inicio', 'Inicio::index');
$routes->get('/inicio/tarea', 'Inicio::tarea');

// Invitaciones Controller
$routes->post('/invitaciones/aceptar', 'Invitaciones::aceptar');
$routes->post('/invitaciones/rechazar', 'Invitaciones::rechazar');

// Login Controller
$routes->get('/login', 'Login::index');
$routes->post('/login/exito', 'Login::exito');
$routes->get('/login/exito', 'Login::exito'); // Esta es una ruta duplicada GET y POST para el mismo URI y método en el controlador
$routes->get('/login/logout', 'Login::logout');

// Producto Controller
$routes->get('/producto', 'Producto::index');

// Registrar Controller
$routes->get('/registrar', 'Registrar::index');
$routes->post('/registrar/guardar', 'Registrar::guardar');

// Tarea Controller
$routes->get('tarea/vertarea/(:num)', 'Tarea::vertarea/$1');
$routes->get('tarea/borrar/(:num)', 'Tarea::borrar/$1');
$routes->get('/tarea/modificar/(:num)', 'Tarea::modificar/$1');
$routes->post('/tarea/modificart', 'Tarea::modificart');
$routes->get('/tarea/modificarsub/(:num)/(:num)', 'Tarea::modificarsub/$1/$2');
$routes->post('/tarea/guardarmod', 'Tarea::guardarmod');
$routes->get('tarea/borrarsub/(:num)/(:num)', 'Tarea::borrarsub/$1/$2');
$routes->post('/tarea/cambiarestadosub', 'Tarea::cambiarestadosub');
$routes->post('/tarea/cambiarestado', 'Tarea::cambiarestado');
$routes->post('/tarea/invitarcolaborador', 'Tarea::invitarcolaborador');
$routes->get('/tarea/archivar/(:num)', 'Tarea::archivar/$1');
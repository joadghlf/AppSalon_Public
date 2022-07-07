<?php

require_once __DIR__ . '/../includes/app.php';

use Controller\AdminController;
use Controller\ApiController;
use Controller\LoguinController;
use Controller\NavegacionPaginas;
use MVC\Router;

$router = new Router();

//Get
$router->get('/',[LoguinController::class,'loguin']);
$router->get('/logout',[LoguinController::class,'logout']);

//Post
$router->post('/',[LoguinController::class,'loguin']);

//recuperar password
$router->get('/olvide',[LoguinController::class,'olvide']);
$router->post('/olvide',[LoguinController::class,'olvide']);
$router->get('/recuperarpassword',[LoguinController::class,'recuperarPassword']);
$router->post('/recuperarpassword',[LoguinController::class,'recuperarPassword']);

//Crear cuenta
$router->get('/crear',[LoguinController::class,'crear']);
$router->post('/crear',[LoguinController::class,'crear']);
//Confirmar cuenta
$router->get('/confirmarcuenta',[LoguinController::class,'confirmarCuenta']);

//Solicitar turno
$router->get('/solicitarturno', [LoguinController::class, 'solicitarTurno']);

//Navegación general
$router->get('/citas',[NavegacionPaginas::class, 'citas']);

//Api de Citas
$router->get('/api/servicios',[ApiController::class, 'index']);
$router->post('/api/reservar',[ApiController::class, 'reservar']);
$router->post('/api/eliminar',[ApiController::class, 'eliminar']);

//Admin
$router->get('/admin/citas',[AdminController::class, 'index']);
$router->get('/admin/servicios',[AdminController::class, 'servicios']);
$router->get('/admin/usuarios',[AdminController::class, 'usuarios']);
//Modificar
$router->get('/admin/citas/modificar',[AdminController::class, 'modificar']);
$router->get('/admin/servicios/modificar',[AdminController::class, 'modificar']);
$router->get('/admin/usuarios/modificar',[AdminController::class, 'modificar']);
$router->post('/admin/citas/modificar',[AdminController::class, 'modificar']);
$router->post('/admin/servicios/modificar',[AdminController::class, 'modificar']);
$router->post('/admin/usuarios/modificar',[AdminController::class, 'modificar']);
//Crear
$router->get('/admin/servicios/crear',[AdminController::class, 'crear']);
$router->get('/admin/usuarios/crear',[AdminController::class, 'crear']);
$router->get('/admin/citas/crear',[AdminController::class, 'crear']);
$router->post('/admin/servicios/crear',[AdminController::class, 'crear']);
$router->post('/admin/usuarios/crear',[AdminController::class, 'crear']);
$router->post('/admin/citas/crear',[AdminController::class, 'crear']);


echo '<pre>';
var_dump($router);
echo '</pre>';
$router->comprobarRutas();



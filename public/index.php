<?php

require_once __DIR__ . '/../app/app.php';

use App\Router;
use Controller\AdminController;
use Controller\UsuarioController;


$router = new Router();
/* Web */
$router->get('/', [UsuarioController::class, 'home']);
$router->post('/', [UsuarioController::class, 'home']);
$router->get('/editar', [UsuarioController::class, 'editar']);
$router->post('/editar', [UsuarioController::class, 'editar']);
/* Admin */
$router->get('/admin', [AdminController::class, 'dashboardPage']);



/* Api */
$API = "/api";
$router->post("${API}/auth/register", [UsuarioController::class, "onRegister"]);
$router->get("${API}/productos", [UsuarioController::class, 'addUser']);

$router->comprobarRutas();
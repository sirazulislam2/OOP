<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use App\Router;
use App\App;
use App\Controllers\CurlController;
use App\Controllers\UserController;
use Illuminate\Container\Container;

require __DIR__ . '/../vendor/autoload.php';

session_start();

define('STORAGE_PATH',__DIR__ . '/../storage');
define('VIEW_PATH',__DIR__ . '/../views');

  $container = new Container();
  $router = new Router($container);

  $router->registerRoutesFromControllerAttributes([
    HomeController::class,
    InvoiceController::class,
    UserController::class,
    CurlController::class,
  ]);
  
  // $router->get('/',[HomeController::class, 'index']);
  // $router->post('/upload',[HomeController::class,'upload']);
  // $router->get('/invoice',[InvoiceController::class,'index']);
  // $router->get('/invoice/create',[InvoiceController::class,'create']);
  // $router->post('/invoice/create',[InvoiceController::class,'store']);

  (new App(
    $container,
    $router,
  ['uri' => $_SERVER['REQUEST_URI'],
  'method' => $_SERVER['REQUEST_METHOD']],
  ))->boot()->run();
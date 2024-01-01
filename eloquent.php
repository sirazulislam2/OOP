<?php
namespace App;
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$capsule = new Capsule;
$params = [
  'database'    => $_ENV['DB_DATABASE'],
  'username'      => $_ENV['DB_USER'],
  'password'  => $_ENV['DB_PASS'],
  'host'      => $_ENV['DB_HOST'],
  'driver'    => $_ENV['DB_DRIVER'] ?? 'mysql',
  'charset' => 'utf8',
  'collation' => 'utf8_unicode_ci',
  'prefix' => '',
];

$capsule->addConnection($params);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();
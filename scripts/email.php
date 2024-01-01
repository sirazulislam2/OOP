<?php

declare(strict_types=1);

use App\App;
use App\Container;
use App\Services\EmailService;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = new Container();

(new App($container,))->boot();
$container->get(EmailService::class)->sendQueuedEmails();
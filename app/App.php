<?php

declare(strict_types = 1);

namespace App;

use App\Contracts\EmailValidationInterface;
use App\Exceptions\RouteNotFoundException;
use App\Services\AbstractApi\EmailValidationService;
use App\Services\Emailable\EmailValidationService as EmailableEmailValidationService;
// use App\Services\Emailable\EmailValidationService;
use App\Services\PaymentGatewayService;
use App\Services\PaymentGatewayServiceInterface;
use Dotenv\Dotenv;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use IntlException;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

class App
{
    protected Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected ?array $request = [],
    ) {
       
    }

    public function initDb(array $config){
        

        $capsule = new Capsule;
  
        $capsule->addConnection($config);
        $capsule->setEventDispatcher(new Dispatcher());
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function boot():static{
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        $this->initDb($this->config->db);

        $loader = new FilesystemLoader(VIEW_PATH);
        $twig = new Environment($loader, [
            'cache' => STORAGE_PATH . '/cache',
            'auto_reload' => true
        ]);

        $twig->addExtension(new IntlExtension());
        
        $this->container->bind(PaymentGatewayServiceInterface::class, PaymentGatewayService::class);

        $this->container->bind(MailerInterface::class, fn() => new CustomMailer($this->config->mailer['dsn']));

        $this->container->bind(EmailValidationInterface::class, fn() => new EmailableEmailValidationService($this->config->apiKeys['emailable']));

        // $this->container->bind(EmailValidationInterface::class, fn() => new EmailValidationService($this->config->apiKeys['abstract_api']));

        $this->container->singleton(Environment::class, fn() => $twig);

        return $this;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}

<?php
namespace App;

use App\Entity\Invoice;
use App\Entity\InvoiceItem;
use App\Enums\InvoiceStatus;
use DateTime;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Faker\Factory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$params = [
  'dbname'    => $_ENV['DB_DATABASE'],
  'user'      => $_ENV['DB_USER'],
  'password'  => $_ENV['DB_PASS'],
  'host'      => $_ENV['DB_HOST'],
  'driver'    => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
];
  $entityManager = new EntityManager(
    DriverManager::getConnection($params),
    ORMSetup::createAttributeMetadataConfiguration([
      __DIR__ . '/Entity',
    ])
  );
// $conn = DriverManager::getConnection($connectionParam);

$query = $entityManager->createQueryBuilder();

$invoice = $query->select('i.createdAt','i.amount')->from(Invoice::class,'i')->where('i.amount > :amount')->setParameter('amount',9000)->orderBy('i.amount', 'desc')->getQuery();
var_dump($invoice->getResult());

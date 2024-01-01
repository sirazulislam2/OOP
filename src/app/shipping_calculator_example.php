<?php
namespace App;

use App\Services\Shipping\DimDiviser;
use App\Services\Shipping\PackageDimension;
use App\Services\Shipping\Weight;

require "./../vendor/autoload.php";
$package = [
  'weight' => 9,
  'dimension' => [
    'width' => '10',
    'height' => '12',
    'length' => '9'
  ]
];

$packageDimesion = new PackageDimension(
  $package['dimension']['width'],
  $package['dimension']['height'],
  $package['dimension']['length']
);

$billableWeight = (new BillableWeightCalculatorService())->calculate(
  $packageDimesion,
  new Weight($package['weight']),
  DimDiviser::FEDEX,
);

echo $billableWeight . ' lb';
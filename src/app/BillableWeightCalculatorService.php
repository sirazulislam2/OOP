<?php
namespace App;

use App\Services\Shipping\DimDiviser;
use App\Services\Shipping\PackageDimension;
use App\Services\Shipping\Weight;
use InvalidArgumentException;

class BillableWeightCalculatorService{
  public function calculate(
    PackageDimension $packageDimension,
    Weight $weight,
    DimDiviser $dimDevisor,
  ){

    $dimWeight = (int) round((
      $packageDimension->width * 
      $packageDimension->height * 
      $packageDimension->length ) / $dimDevisor->value);

    return max($weight->value, $dimWeight);
  }
} 
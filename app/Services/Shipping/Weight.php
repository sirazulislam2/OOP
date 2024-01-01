<?php
namespace App\Services\Shipping;

use InvalidArgumentException;

class Weight{
  public function __construct(public readonly int $value)
  {
    if ($this->value <= 0 || $this->value > 80) {
      throw new InvalidArgumentException('Invalid Package height');
    }
  }

  public function equalTo(Weight $other){
    return $this->value == $other->value;
  }
}
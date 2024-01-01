<?php
namespace App\DTO;
class EmailValidationResult{
  public function __construct(public readonly string $score, public readonly bool $deliverability)
  {
  }
} 
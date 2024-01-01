<?php 
namespace App\Contracts;

use App\DTO\EmailValidationResult;

interface EmailValidationInterface{
  public function varify(string $email): EmailValidationResult;
}
<?php
namespace App\Controllers;

use App\Attributes\Get;
use App\Contracts\EmailValidationInterface;
use App\Services\Emailable\EmailValidationService;

class CurlController{

  public function __construct(public EmailValidationInterface $emailValidationService)
  {
  }

  #[Get('/curl')]
  public function index(){
    $email = 'mdsirazulisl@gmail.com';
    $result = $this->emailValidationService->varify($email);

    $scrore = $result->score;
    $delivarability = $result->deliverability;

    var_dump($scrore,$delivarability);

    echo '<pre>';
      print_r($result);
    echo '</pre>';
  }
} 
<?php
namespace Tests\Unit\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGetwayService;
use App\Services\SalesTaxService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase{

  public function test_it_process_invoice():void{

    $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
    $paymentGetwayServiceMock = $this->createMock(PaymentGetwayService::class);
    $emailServiceMock = $this->createMock(EmailService::class);

    $paymentGetwayServiceMock->method('charge')->willReturn(true);

    $invoiceService = new InvoiceService(
      $salesTaxServiceMock,
      $paymentGetwayServiceMock,
      $emailServiceMock
    );

    $customer = ['name' => 'sirazul'];
    $amount = 250;
    $result = $invoiceService->process($customer,$amount);

    $this->assertTrue($result);
  }

  public function test_it_sends_receipt_email_when_process_method_is_call():void{
    
    $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
    $paymentGetwayServiceMock = $this->createMock(PaymentGetwayService::class);
    $emailServiceMock = $this->createMock(EmailService::class);

    $paymentGetwayServiceMock->method('charge')->willReturn(true);

    $invoiceService = new InvoiceService(
      $salesTaxServiceMock,
      $paymentGetwayServiceMock,
      $emailServiceMock
    );
    $emailServiceMock
      ->expects($this->once())
      ->method('send')
      ->with(['name' => 'sirazul'],'receipt'
    );
    
    $customer = ['name' => 'sirazul'];
    $amount = 250;
    $result = $invoiceService->process($customer,$amount);

    $this->assertTrue($result);
  }
} 
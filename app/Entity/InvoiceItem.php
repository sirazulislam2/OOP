<?php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table('invoice_items')]
class InvoiceItem{
  #[Id]
  #[Column(),GeneratedValue()]
  private int $id;
  
  #[Column(name: 'invoice_id')]
  private int $invoiceId;

  #[Column()]
  private string $description;

  #[Column()]
  private int $quantity;

  #[Column(name: 'unit_price', type:Types::DECIMAL, precision:10,scale:2)]
  private float $unitPrice;

  #[ManyToOne(inversedBy: 'items')]
  private Invoice $invoice;

  public function getId()
  {
    return $this->id;
  }

  public function getInvoiceId()
  {
    return $this->invoiceId;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setDescription($description): InvoiceItem
  {
    $this->description = $description;

    return $this;
  }

  public function getQuantity()
  {
    return $this->quantity;
  }

  public function setQuantity($quantity):InvoiceItem
  {
    $this->quantity = $quantity;

    return $this;
  }

  public function getUnitPrice()
  {
    return $this->unitPrice;
  }

  public function setUnitPrice($unitPrice): InvoiceItem
  {
    $this->unitPrice = $unitPrice;

    return $this;
  }

  public function getInvoice()
  {
    return $this->invoice;
  }

  public function setInvoice($invoice)
  {
    $this->invoice = $invoice;

    return $this;
  }
} 
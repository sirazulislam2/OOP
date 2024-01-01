<?php
namespace App\Entity;

use App\Enums\InvoiceStatus;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[Entity()]
#[Table('invoices')]
#[HasLifecycleCallbacks]
class Invoice{
  #[Id]
  #[Column(),GeneratedValue()]
  private int $id;

  #[Column(type:Types::DECIMAL,precision:10,scale:2)]
  private float $amount;

  #[Column()]
  private InvoiceStatus $status;

  #[Column(name:'invoice_number')]
  private string $invoiceNumber;

  #[Column(name: 'created_at')]
  private DateTime $createdAt;

  #[OneToMany(targetEntity:InvoiceItem::class, mappedBy:'invoice')]
  private Collection $items;

  public function __construct()
  {
    $this->items = new ArrayCollection();
  }

  public function onPrePersist(LifecycleEventArgs $args){
    $this->createdAt = new DateTime();
  }

  public function getId()
  {
    return $this->id;
  }

  public function getAmount()
  {
    return $this->amount;
  }

  public function setAmount($amount): Invoice
  {
    $this->amount = $amount;

    return $this;
  }

  public function getStatus(): InvoiceStatus
  {
    return $this->status;
  }

  public function setStatus(InvoiceStatus $status): Invoice
  {
    $this->status = $status;

    return $this;
  }

  public function getInvoiceNumber()
  {
    return $this->invoiceNumber;
  }

  public function setInvoiceNumber($invoiceNumber):Invoice
  {
    $this->invoiceNumber = $invoiceNumber;

    return $this;
  }

  public function getCreatedAt(): DateTime
  {
    return $this->createdAt;
  }

  public function getItems(): Collection
  {
    return $this->items;
  }

  public function addItem(InvoiceItem $item): Invoice{
    $item->setInvoice($this);
    $this->items->add($item);
    return $this;
  }

} 
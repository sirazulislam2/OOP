<?php
namespace App;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Capsule\Manager as Capsul;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../eloquent.php';

$invoiceId = 2;

// echo Invoice::query()->where('id',$invoiceId)->update(['status' => InvoiceStatus::Pending]);
Invoice::query()->where('status',InvoiceStatus::Pending)->get()->each(function(Invoice $invoice){
  echo $invoice->id . ', ' . $invoice->created_at->format('m/d/Y') . ', ' . $invoice->status->toString() . PHP_EOL;
  $item = $invoice->items->first();
  var_dump($item->description);
}); 

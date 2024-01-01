<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\View;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment as Twig;

class InvoiceController
{

    public function __construct(private Twig $twig)
    {
        
    }

    #[Get('/invoices')]
    public function index(): string
    {
        $invoices = Invoice::query()->where('status', InvoiceStatus::Paid)->get()->toArray();

        return $this->twig->render('invoices/index.twig', ['invoices' => $invoices]);
    }
}

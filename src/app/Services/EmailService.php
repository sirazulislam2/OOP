<?php

declare(strict_types = 1);

namespace App\Services;

use App\Enums\EmailStatus;
use App\Models\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as MimeEmail;

class EmailService
{

    public function __construct(protected Email $emailModel, protected MailerInterface $mailer)
    {
    }

    public function sendQueuedEmails(): void
    {
        $emails = $this->emailModel->getEmailByStatus(EmailStatus::Queue);
        foreach ($emails as $email) {
            $meta = json_decode($email->meta,true);
            $emailMessage = (new MimeEmail())
            ->from($meta['from'])
            ->to($meta['to'])
            ->subject($email->subject)
            ->text($email->text_body)
            ->html($email->html_body);
            
            $this->mailer->send($emailMessage);

            $this->emailModel->markEmailSent($email->id);
        }
    }
}

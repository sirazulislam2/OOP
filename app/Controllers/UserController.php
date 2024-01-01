<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\Models\Email as ModelsEmail;
use App\View;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class UserController
{
    public function __construct(protected MailerInterface $mailer)
    {
    }

    #[Get('/users/create')]
    public function create(): View
    {
        return View::make('users/register');
    }

    #[Post('/users')]
    public function register()
    {
        $name      = $_POST['name'];
        $email     = $_POST['email'];
        $firstName = explode(' ', $name)[0];
        $subject = 'Welcome';
        $text = <<<Body
Hello $firstName,

Thank you for signing up!
Body;

        $html = <<<HTMLBody
<h1 style="text-align: center; color: blue;">Welcome</h1>
Hello $firstName,
<br /><br />
Thank you for signing up!
HTMLBody;

        (new ModelsEmail())->Queue(
            new Address($email),
            new Address('support@gmail.com','Support'),
            $subject,
            $html,
            $text
        );

    }
}
// $email = (new Email())
// ->from('support@example.com')
// ->to($email)
// ->subject('Welcome!')
// ->attach('Hello World!', 'welcome.txt')
// ->text($text)
// ->html($html);

// $this->mailer->send($email);
<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailService {
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($to, $subject, $template, $data = null){
        $email = (new TemplatedEmail())
            ->from('carsery.app@gmail.com')
            ->to($to)
            ->subject($subject)
            ->htmlTemplate('emails/'.$template.'.html.twig');
            if(!is_null($data)){
                $email->context([
                    'data' => $data
                ]);
            }
        $this->mailer->send($email);
    }
}

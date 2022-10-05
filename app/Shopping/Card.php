<?php

namespace App\Shopping;


class Card {

    public $email;
    public $message;

    private $paymentGateway;
    private $mailer;

    public function __construct(PaymentsInterface $paymentGateway, Mailer $mailer)
    {
        $this->paymentGateway = $paymentGateway;
        $this->mailer = $mailer;
    }

    public function submit() {

        $paymentResult = $this->paymentGateway->charge(100);

        $this->mailer->deliver('test@gmail.com', $this->message . $paymentResult);

        return true;
    }
}
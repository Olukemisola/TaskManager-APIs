<?php

namespace Main\Service\Notifier;

use Main\Interface\Services\INotifier;
use Main\Interface\Services\INotifierGeneric;

class Notifier implements INotifierGeneric
{
    public function __construct(
        private readonly INotifier $emailNotifier,
        private readonly INotifier $smsNotifier
    ) {}

    public function sendEmail($email, $body)
    {
        $this->emailNotifier->update($email, $body);
    }

    public function sendSms($phone, $message)
    {
        $this->smsNotifier->update($phone, $message);
    }

    public function send(string $phone, string $email, string $message)
    {
        $this->sendEmail($email, $message);
        $this->sendSms($phone, $message);
    }
}

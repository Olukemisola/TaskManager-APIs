<?php

namespace Main\Interface\Services;

interface INotifierGeneric
{
    public function sendEmail($email, $body);

    public function sendSms($phone, $message);

    public function send(string $phone, string $email, string $message);
}

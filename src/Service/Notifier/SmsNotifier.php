<?php

namespace Main\Service\Notifier;

use Main\Interface\Services\INotifier;

class SmsNotifier implements INotifier
{
  public function update($phone, $message): bool
  {
    //  "Email Notification: " . $message;

    return true;
  }
}

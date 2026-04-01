<?php

namespace Main\Service\Notifier;

use Main\Interface\Services\INotifier;

class EmailNotifier implements INotifier
{
  public function update($email, $message): bool
  {
    // return "Email Notification: " . $message;
    return true;
  }
}

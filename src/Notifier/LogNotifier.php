<?php

namespace Main\Notifier;

class LogNotifier implements ObserverInterface
{
    public function update($message)
    {
      return "Email Notification: " . $message;

    }
}
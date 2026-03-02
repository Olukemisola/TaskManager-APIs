<?php

namespace Main\Notifier;

class EmailNotifier implements ObserverInterface 
{
    public function update($message)
    {
      return "Email Notification: " . $message;

    }
}
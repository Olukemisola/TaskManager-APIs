<?php

namespace Main\DI;

use Main\Controller\taskController;
use Main\Decorator\CacheDecorator;
use Main\Decorator\LoggingDecorator;
use Main\Repository\MongoDB\TaskRepository as MongoDBTaskRepository;
use Main\Repository\UserRepository;
use Main\Service\TaskServiceImpl;
use Main\Service\Notifier\EmailNotifier;
use Main\Service\Notifier\Notifier;
use Main\Service\Notifier\SmsNotifier;
use Main\UseCase\TaskUseCase;

// Repositories
$taskRepository = new MongoDBTaskRepository();
$userRepository = new UserRepository();

// -----------------------------
// Notifier setup
// -----------------------------
$emailNotifier = new EmailNotifier();
$smsNotifier = new SmsNotifier();
$notifier = new Notifier($emailNotifier, $smsNotifier);

// 1. Original Service
$taskService = new TaskServiceImpl($taskRepository);

// 2. Decorators (WRAPPING)

$taskService = new CacheDecorator($taskService);
$taskService = new LoggingDecorator($taskService);


// 3. UseCase (now depends on SERVICE, not repository)

$taskUseCase = new TaskUseCase(
    $taskService,
    $userRepository,
    $notifier
);

// 4. Controller

$taskcontroller = new taskController($taskUseCase);

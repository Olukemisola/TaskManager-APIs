<?php

namespace Main\DI;

use Main\Controller\taskController;
use Main\Repository\MongoDB\TaskRepository as MongoDBTaskRepository;
use Main\Repository\TaskRepository;
use Main\Repository\UserRepository;
use Main\Service\Notifier\EmailNotifier;
use Main\Service\Notifier\Notifier;
use Main\Service\Notifier\SmsNotifier;
use Main\UseCase\TaskUseCase;

$taskSqlRepository = new TaskRepository();
$taskMongoRepository = new MongoDBTaskRepository();

$userRepository = new UserRepository();

$emailNotifier = new EmailNotifier();
$smsNotifier = new SmsNotifier();
$notifier = new Notifier($emailNotifier, $smsNotifier);

$taskUseCase = new TaskUseCase($taskMongoRepository, $userRepository, $notifier);

$taskcontroller = new taskController($taskUseCase);

<?php

namespace Main\UseCase;

use Main\Factory\TaskFactory;

use Main\Interface\Services\ITaskService;
use Main\Interface\Repository\ITaskRepository;
use Main\Interface\Services\INotifierGeneric;
use Main\Interface\UseCase\ITaskUseCase;
use Main\Repository\UserRepository;

class TaskUseCase implements ITaskUseCase
{
    private readonly ITaskRepository $taskRepo;
    private readonly UserRepository $userRepo;

    public function __construct(
        private readonly ITaskService $taskService,
        private UserRepository $user_repository,
        private readonly INotifierGeneric $notifier
    ) {
        // $this->taskRepo = $taskRepo;
        $this->userRepo = $user_repository;
    }

    public function create($userData)
    {
        $task = TaskFactory::create(
            $userData['type'] ?? 'bug',
            $userData['title'] ?? 'Untitled Task',
            $userData['priority'] ?? 'low'
        );

        $result = [
            'task_type' => $task->getType(),
            'title' => $task->getTitle()
        ];

        $phone = ""; // get phone from the user
        $email = ""; // get email from the user
        $message = ""; // get message from wherever it is defined


        // $this->notifier->sendEmail($email, $message);
        // $this->notifier->sendSms($phone, $message);
        $this->notifier->send($phone, $email, $message);

        // (new SmsNotifier())->update($phone, $message);

        return $result;
    }
    public function getAll()
    {

        return  $this->taskRepo->getAll();
    }
    public function updateStatus($id, $completed)
    {
        $success = $this->taskRepo->updateStatus($id, $completed);


        return [
            'success' => $success,
            'id' => $id,
            'completed' => $completed
        ];
    }
}

//this is the new one of decorator i commented , i am to work on the commnted one and the one i commented in my DI and Task service and ItaseService
// <?php

// namespace Main\UseCase;

// use Main\Factory\TaskFactory;
// use Main\Interface\Services\ITaskService;
// use Main\Interface\Services\INotifierGeneric;
// use Main\Interface\UseCase\ITaskUseCase;
// use Main\Repository\UserRepository;

// class TaskUseCase implements ITaskUseCase
// {
//     public function __construct(
//         private ITaskService $taskService,
//         private UserRepository $userRepo,
//         private INotifierGeneric $notifier
//     ) {}

//     public function create($userData)
//     {
//         $task = TaskFactory::create(
//             $userData['type'] ?? 'bug',
//             $userData['title'] ?? 'Untitled Task',
//             $userData['priority'] ?? 'low'
//         );

//         $this->notifier->send("", "", "");

//         return [
//             'task_type' => $task->getType(),
//             'title' => $task->getTitle()
//         ];
//     }

//     public function getAll()
//     {
//         return $this->taskService->getAllTasks();
//     }

//     public function updateStatus($id, $completed)
//     {
//         $success = $this->taskService->updateStatus($id, $completed);

//         return [
//             'success' => $success,
//             'id' => $id,
//             'completed' => $completed
//         ];
//     }
// }
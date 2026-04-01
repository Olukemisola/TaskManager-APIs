<?php

namespace Main\UseCase;

use Main\Factory\TaskFactory;
use Main\Interface\Repository\ITaskRepository;
use Main\Interface\Services\INotifierGeneric;
use Main\Interface\UseCase\ITaskUseCase;
use Main\Repository\UserRepository;

class TaskUseCase implements ITaskUseCase
{
    // private readonly ITaskRepository $taskRepo;
    private readonly UserRepository $userRepo;

    public function __construct(
        private readonly ITaskRepository $taskRepo,
        UserRepository $userRepo,
        private readonly INotifierGeneric $notifier
    ) {
        // $this->taskRepo = $taskRepo;
        $this->userRepo = $userRepo;
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

        // trigger notification if needed
        if ($success) {
            $this->notifier->send("", "", "Task updated");
        }

        return [
            'success' => $success,
            'id' => $id,
            'completed' => $completed
        ];
    }
}

<?php

namespace Main\Controller;

use Main\Factory\TaskFactory;
use Main\Interface\Repository\ITaskRepository;
use Main\Interface\Services\INotifier;
use Main\Interface\Services\INotifierGeneric;
use Main\Interface\UseCase\ITaskUseCase;
use Main\Model\GenericTask;
use Main\Repository\TaskRepository;
use Main\Repository\UserRepository;
use Main\Service\Notifier\EmailNotifier;
use Main\Service\Notifier\LogNotifier;
use Main\Service\Notifier\SmsNotifier;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class taskController
{
    public function __construct(
        private readonly ITaskUseCase $taskUseCase
    ) {}

    public function create(Request $request, Response $response)
    {
        try {
            $userData = $request->getParsedBody() ?? $request->getBody();

            $result = $this->taskUseCase->create($userData);

            $response->getBody()->write(json_encode($result));

            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (Throwable $err) {
            $error = [
                "message" => $err->getMessage()
            ];
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(400);
        }
    }

    public function updateCompleted(Request $request, Response $response, array $args)
    {
        try {
            $taskId = $request->getAttribute('id');

            $data = (array) json_decode($request->getBody()->getContents(), true);
            $completed = $data['completed'];

            $task = new GenericTask("title");

            //  Attach observers
            // $task->attach(new EmailNotifier());
            // $task->attach(new LogNotifier());

            //  Update completed status (this updates DB + notifies observers)
            $success = $task->setCompleted($taskId, $completed);

            $payload = [
                'success' => $success,
                'task_id' => $taskId,
                'completed' => $completed
            ];

            $response->getBody()->write(json_encode($payload));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($success ? 200 : 500);
        } catch (Throwable $err) {
            $error = ["message" => $err->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    public function createTask(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $taskRepository = new TaskRepository();

        $taskRepository->createTask(
            $data['title'],
            $data['description'],
            0,
            $data['assignedUser']
        );

        $response->getBody()->write(json_encode([
            'message' => 'Task created successfully'
        ]));

        return $response;
    }

    public function getAll(Request $request, Response $response)
    {
        try {
            $tasks = $this->taskUseCase->getAll();
            $response->getBody()->write(json_encode($tasks));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Throwable $err) {
            $response->getBody()
                ->write(json_encode(['message' => $err->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    public function updateStatus(Request $request, Response $response, $args)
    {
        try {
            $id = $request->getAttribute('id') ?? null;
            $data = $request->getParsedBody();
            $completed = $data['completed'] ?? null;

            // $this->taskRepo->updateStatus($id, $completed);
            $success = $this->taskUseCase->updateStatus($id, $completed);

            $response->getBody()->write(json_encode([
                'message' => 'Task status updated successfully',
                'id' => $id,
                'completed' => $completed
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Throwable $err) {
            $response->getBody()
                ->write(json_encode([
                    'message' => $err->getMessage()
                ]));
            return $response
                ->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}

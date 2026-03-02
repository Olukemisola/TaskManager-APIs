<?php

namespace Main\Controller;

use Main\Factory\TaskFactory;
use Main\Model\GenericTask;
use Main\Notifier\EmailNotifier;
use Main\Notifier\LogNotifier;
use Main\Strategy\LowPriorityStrategy;
use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class taskController
{

public function create(Request $request, Response $response)
{
try{
    $userData = $request->getParsedBody();
  
        $task = TaskFactory::create(
            $userData['type'] ?? 'bug',
            $userData['title'] ?? 'Untitled Task',
            $userData['priority'] ?? 'low' 
        );

        $result = [
            'task_type' => $task->getType(),
            'title' => $task->getTitle()
        ];


     $response->getBody()->write(json_encode($result));

            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);

}catch (Throwable $err) {
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
            $task->attach(new EmailNotifier());
            $task->attach(new LogNotifier());

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
}








?>
<?php

namespace Main\Controller;

use Main\Factory\TaskFactory;
use Main\Strategy\LowPriorityStrategy;
use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

class taskController
{

public function create(Request $request, Response $response){
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

}








?>
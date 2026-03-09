<?php

namespace Main\Controller;

use Main\Factory\TaskFactory;
use Main\Model\GenericTask;
use Main\Notifier\EmailNotifier;
use Main\Notifier\LogNotifier;
use Main\Repository\UserRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class taskController{

    public function createUser(Request $request, Response $response)
    {
        try {
            $data = $request->getParsedBody();

            $name = $data['name'] ?? '';
            $email = $data['email'] ?? '';

         $user= new UserRepository();
            $result = [
                'message' => 'User created successfully',
                'name' => $name,
                'email' => $email
            ];

            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);

        } catch (\Throwable $err) {
            $error = [
                'message' => $err->getMessage()
            ];
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    public function getById(Request $request, Response $response, $args)
    {
     $id= $request->getAttribute('id');

        if (!$id) {
            $response->getBody()->write(json_encode(['message' => 'ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

         $user= new UserRepository();

        if (!$user) {
            $response->getBody()->write(json_encode(['message' => 'User not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getAll(Request $request, Response $response)
    {
         $users= new UserRepository();

        $response->getBody()->write(json_encode($users));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function update(Request $request, Response $response, $args)
    {
     $id=$request->getAttribute('id');
        $data = $request->getParsedBody();

        if (!$id) {
            $response->getBody()->write(json_encode(['message' => 'ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';

         $user= new UserRepository();

        $response->getBody()->write(json_encode([
            'message' => 'User updated successfully',
            'id' => $id,
            'name' => $name,
            'email' => $email
        ]));
   return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function delete(Request $request, Response $response, $args)
    {
     $id=$request->getAttribute('id');
        if (!$id) {
            $response->getBody()->write(json_encode(['message' => 'ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

         $user= new UserRepository();

        $response->getBody()->write(json_encode(['message' => 'User deleted successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}















?>
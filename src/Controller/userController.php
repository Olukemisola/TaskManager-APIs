<?php

namespace Main\Controller;

use Main\Factory\TaskFactory;
use Main\Model\GenericTask;
use Main\Notifier\EmailNotifier;
use Main\Notifier\LogNotifier;
use Main\Repository\UserRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class userController{
private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function createUser(Request $request, Response $response)
    {
        try {
            $data = $request->getParsedBody();

            $name = $data['name'] ?? null;
            $email = $data['email'] ??null;

            $this->userRepo->createUser($name, $email);
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
        try{
         $id= $request->getAttribute('id');
          $user = $this->userRepo->getById($id);

            $response->getBody()->write(json_encode($user));
            return $response
            ->withHeader('Content-Type', 'application/json')->withStatus(200);

        } catch (\Throwable $err) {
            $response->getBody()
            ->write(json_encode(['message' => $err->getMessage()]));
            return $response
            ->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

  

    public function getAll(Request $request, Response $response)
    {
        try {
            $users = $this->userRepo->getAll();
            $response->getBody()->write(json_encode($users));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

        } catch (\Throwable $err) {
            $response->getBody()
            ->write(json_encode(['message' => $err
            ->getMessage()]));
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(400);
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        try{
        $id=$request->getAttribute('id');

          $data = $request->getParsedBody();
            $name = $data['name'] ??null;
            $email = $data['email'] ??null;

            $this->userRepo->updateUser($id, $name, $email);

            $response->getBody()->write(json_encode([
                'message' => 'User updated successfully',
                'id' => $id,
                'name' => $name,
                'email' => $email
            ]));
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);

        } catch (\Throwable $err) {
            $response->getBody()
            ->write(json_encode(['message' => $err->getMessage()]));
            return $response
            ->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }



    }
















?>
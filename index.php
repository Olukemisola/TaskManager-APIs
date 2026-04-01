<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Models/userModel.php';
require_once __DIR__ . '/../src/Models/taskModel.php';

require 'Container.php';

require_once "src/DI/DI.php";

$app = Slim\App::create();


// $container = $app->getContainer();

// $app->post('/users', function ($request, $response) use ($container) {
//     $controller = $container['userController']($container);
//     return $controller->createUser($request, $response);
// });

$app->get('/users', function ($request, $response) use ($taskcontroller) {
    return $taskcontroller->getAll($request, $response);
});



$app->run();

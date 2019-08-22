<?php

use App\Controller\PostController;
use App\Router;
use Symfony\Component\HttpFoundation\Request;

$router = new Router();

$router->get(
    'hello/{(\d+)}/omar/{nickname}',
    function (Request $request, int $id , string $nickname) {
        return PostController::index($request);
    }
);

$router->get(
    '/',
    function (Request $request) {
        return "HELLO ";
    }
);

$router->run();
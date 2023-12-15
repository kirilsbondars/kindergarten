<?php

// const for paths
const ROOT_DIR = __DIR__;
const AUTH_DIR = __DIR__ . '/design/auth/';
const NEWS_DIR = __DIR__ . '/design/news/';
const BASE_DIR = __DIR__ . '/design/base/';
const CONTENT_DIR = __DIR__ . '/content/';
const IMAGE_DIR = __DIR__ . '/img/';
const CONTROLLERS_DIR = __DIR__ . '/content/controllers/';

// init database connection, session and current user
require 'vendor/autoload.php';
require_once CONTENT_DIR . 'Database.php';
require_once CONTROLLERS_DIR . 'User.php';

Database::connect();
session_start();
$current_user = User::get_current_user();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute(['GET', 'POST'], '/login', AUTH_DIR . 'login.php');
    $r->addRoute(['GET', 'POST'], '/sign_up', AUTH_DIR . 'sign_up.php');
    $r->addRoute('GET', '/logout', AUTH_DIR . 'logout.php');
    $r->addRoute('GET', '/news', NEWS_DIR . 'view_all.php');
    $r->addRoute(['GET', 'POST'], '/news_article/create', NEWS_DIR . 'create.php');
    $r->addRoute('GET', '/news_article/view/{id:\d+}', NEWS_DIR . 'view.php');
    $r->addRoute(['GET', 'POST'], '/news_article/update/{id:\d+}', NEWS_DIR . 'update.php');
    $r->addRoute('GET', '/news_article/delete/{id:\d+}', NEWS_DIR . 'delete.php');
    // ... add more routes as needed ...
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        require BASE_DIR . '404.php';
        http_response_code(404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $_GET = array_merge($_GET, $vars); // Merge route parameters into $_GET
        require $handler;
        break;
}
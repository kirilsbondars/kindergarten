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
require_once CONTENT_DIR . 'Database.php';
require_once CONTROLLERS_DIR . 'User.php';
Database::connect();
session_start();
$current_user = User::get_current_user();


$request = $_SERVER['REQUEST_URI'];

// delete news article with specific id
if (preg_match('/\/news\/delete\/(\d+)/', $request, $matches)) {
    $_GET['id'] = $matches[1];
    require NEWS_DIR . 'delete.php';
    exit();
}

// edit news article with specific id
if (preg_match('/\/news\/update\/(\d+)/', $request, $matches)) {
    $_GET['id'] = $matches[1];
    require NEWS_DIR . 'update.php';
    exit();
}

// view news article with specific id
if (preg_match('/\/news\/view\/(\d+)/', $request, $matches)) {
    $_GET['id'] = $matches[1];
    require NEWS_DIR . 'view.php';
    exit();
}

if (preg_match('/\/news/', $request)) {
    $_GET['search'] = $_GET['search'] ?? null;
    require NEWS_DIR . 'view_all.php';
    exit();
}

// access to images stored in /img/ folder
if (preg_match('/\/img\/(.+)/', $request, $matches)) {
    $imagePath = IMAGE_DIR . $matches[1];
    if (file_exists($imagePath)) {
        header('Content-Type: ' . mime_content_type($imagePath));
        readfile($imagePath);
        exit();
    }
}

switch ($request) {
    case '/login':
        require AUTH_DIR . 'login.php';
        break;

    case '/sign_up':
        require AUTH_DIR . 'sign_up.php';
        break;

    case '/logout':
        require AUTH_DIR . 'logout.php';
        break;

    case '/news':
        require NEWS_DIR . 'view_all.php';
        break;

    case '/news/view':
        require NEWS_DIR . 'view.php';
        break;

    case '/news/create':
        require NEWS_DIR . 'create.php';
        break;

    default:
        http_response_code(404);
}
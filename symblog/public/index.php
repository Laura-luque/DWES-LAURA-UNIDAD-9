<?php
require_once "../bootstrap.php";
require '../vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\IndexControllers;
use App\Controllers\UsersController;
use App\Controllers\AuthController;
use Aura\Router\RouterContainer;
// use  Laminas\Diactoros\Response\HtmlResponse;
session_start();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
$routeContainer = new RouterContainer();

$map = $routeContainer->getMap();

$map->get('home', '/', [IndexControllers::class, 'indexAction', false]);
$map->get('newblog', '/addBlog', [IndexControllers::class, 'newBlogAction', false]);
$map->get('contact', '/contact', [IndexControllers::class, 'contactAction', true]);
$map->get('about', '/about', [IndexControllers::class, 'aboutAction', false]);
$map->get('show', '/show', [IndexControllers::class, 'showAction', false]);
$map->get("newuser", "/addUser", [UsersController::class, 'newUserAction', true]);
$map->get("formlogin", "/login", [AuthController::class, 'formLoginAction', false]);
$map->get("logout", "/logout", [AuthController::class, 'getLogout', true]);
$map->get("admin", "/admin", [AdminController::class, 'getIndex', true]);

$map->post('addblog', '/addBlog', [IndexControllers::class, 'addBlogAction', false]);
$map->post("addUser", "/addUser", [UsersController::class, 'addUserAction', false]);
$map->post("login", "/login", [AuthController::class, 'postLoginAction', false]);
$map->post("addComment", "/show", [IndexControllers::class, 'addComments', false]);

$route = $_GET["route"] ?? ""; 

$matcher = $routeContainer->getMatcher();
$route = $matcher->match($request);
if (!$route) {
    echo 'No route';
} else {
    $handlerData = $route->handler;
    $controllerName = $handlerData[0];
    $actionName = $handlerData[1];
    $needsAuth = $handlerData[2] ?? false;
    $sessionUserId = $_SESSION["userId"] ?? null;
    if ($needsAuth && !$sessionUserId) {
        header("Location: /login");
        exit;
    }
    $controller = new $controllerName;
    $response = $controller->$actionName($request);
    
    if ($response === null) {
        echo '$response es null';
    } else {
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf("%s: %s", $name, $value), false);
            }
        }
        echo $response->getBody();
    }
}
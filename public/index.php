<?php

require_once 'config.php';

$router = new Core\Router();

$router->addRoute('',['controller'=>'home','action'=>'index']);
$router->addRoute('{controller}/{action}');
$router->addRoute('{controller}/{id:\d+}',['action'=>'show-lot-by-id']);

$router->dispatch($_GET['url']);

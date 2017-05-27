<?php

require_once 'config.php';

$router = new Yeticave\Core\Router();

$router->addRoute('',['controller'=>'home','action'=>'index']);
$router->addRoute('search/{searchstring:(.*)}',['controller'=> 'home','action'=>'search']);
$router->addRoute('{controller}/{id:\d+}',['action'=>'show-lot-by-id']);
$router->addRoute('{controller}/{action}');

/*echo '<pre>';
var_dump($router->getRoutes());
echo '</pre>';*/

$router->dispatch($_GET['url']);

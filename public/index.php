<?php

require_once 'config.php';

$router = new Yeticave\Core\Router();

$router->addRoute('', ['controller' => 'home', 'action' => 'index']);

$router->addRoute('search/suggest/{searchstring:(.*)}',
['controller' => 'home', 'action' => 'search-suggest']);

$router->addRoute('search/{searchstring:(.*)}', ['controller'=> 'home', 'action'=>'search']);
$router->addRoute('lot/{id:\d+}', ['controller' => 'lot', 'action' => 'show-lot-by-id']);
$router->addRoute('category/{id:\d+}', ['controller' => 'lot', 'action' => 'show-lots-by-category-id']);
$router->addRoute('{controller}/{action}');

$router->dispatch($_GET['url']);

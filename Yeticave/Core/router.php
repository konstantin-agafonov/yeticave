<?php

namespace Yeticave\Core;

use Yeticave\App\Models\Categories;

class Router {

    protected $routes = [];
    protected $params = [];

    public function addRoute(string $route,array $params = []) {
        $route = preg_replace('/\//','\\/',$route);
        $route = preg_replace('/\{([a-z-]+)\}/','(?P<\1>[a-z-]+)',$route);
        $route = preg_replace('/\{([a-z-]+):([^\}]+)\}/','(?P<\1>\2)',$route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }

    public function getRoutes() : array {
        return $this->routes;
    }

    public function getParams() : array {
        return $this->params;
    }

    public function match(string $url) : bool {
        foreach($this->routes as $route => $params) {
            if (preg_match($route,$url,$matches)) {
                foreach($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * TODO: комментарий добавить
     * @param string $url
     */
    public function dispatch(string $url) {

        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object,$action])) {
                    $result = $controller_object->$action();
                    if ($result !== null) {
                        echo $result;
                    }
                    die();
                } else {
                    echo "Method $action (in controller $controller) not found";
                }
            } else {
                echo "Controller class $controller not found";
            }
        } else {

            header('HTTP/1.1 404 Not Found');
            View::render('home/message.php', [
                'categories' => Categories::selectAll(),
                'user' => new User('Core\Db'),
                'message' => '<p>No route matched! <a href="/">На главную</a></p>'
            ]);
            die();

        }
    }

    protected function convertToStudlyCaps(string $string) : string {
        return str_replace(' ','',ucwords(str_replace('-',' ',$string)));
    }

    protected function convertToCamelCase(string $string) : string {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    protected function removeQueryStringVariables($url) {
        if ($url != '') {
            $parts = explode('&',$url,2);
            if (strpos($parts[0],'=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    protected function getNamespace()
    {
        $namespace = 'Yeticave\App\Controllers\\';

        if (array_key_exists('namespace',$this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }

}
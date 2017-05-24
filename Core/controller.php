<?php

namespace Core;

abstract class Controller {

    protected $route_params = [];

    public function __construct(array $route_params)
    {
        $this->route_params = $route_params;
    }

    public function __call($name,$args)
    {
        $method = $name . 'Action';

        if (method_exists($this,$method)) {
            if ($this->before() !== false) {
                file_put_contents(__DIR__ . '/log.txt', $method . PHP_EOL,FILE_APPEND);
                call_user_func_array([$this,$method],$args);
                $this->after();
            }
        } else {
            echo "Method $method not found in controller" . get_class($this);
        }
    }

    protected function before()
    {

    }

    protected function after()
    {

    }


}
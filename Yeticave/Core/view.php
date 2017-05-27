<?php

namespace Yeticave\Core;

class View
{

    public static function render($view,$args = [])
    {
        extract($args,EXTR_SKIP);

        $file = "../Yeticave/App/Views/$view";
        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found";
        }
    }

}
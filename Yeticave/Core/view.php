<?php

namespace Yeticave\Core;

class View
{

    public static function render($view,$args = [])
    {
        extract($args,EXTR_SKIP);

        $file2require = "../Yeticave/App/Views/$view";
        if (is_readable($file2require)) {
            require $file2require;
        } else {
            echo "$file2require not found";
        }
    }

}
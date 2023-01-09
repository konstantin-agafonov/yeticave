<?php

namespace Yeticave\Core;

class View
{
    /**
     * TODO: комментарий
     * @param $view
     * @param array $args
     * @return string
     */
    public static function render($view, $args = []) : string
    {
        extract($args,EXTR_OVERWRITE);

        $file2require = realpath(__DIR__ . "/../App/Views/$view");

        if (file_exists($file2require) && is_readable($file2require)) {
            ob_start();
            include $file2require;
            $template = ob_get_clean();
            return $template;
        }

        return '';
    }
}

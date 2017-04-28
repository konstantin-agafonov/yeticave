<?php

function includeTemplate(string $path2template = null, array $data = null) : string {
    if (!isset($path2template)) {
        return '';
    }
    ob_start();
    include $path2template;
    $template = ob_get_clean();
    return $template;
}
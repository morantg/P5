<?php
namespace controller;

use \Twig_Loader_Filesystem;
use \Twig_Environment;

class Controller
{

    protected function render($view, $variables = [])
    {
        $loader = new Twig_Loader_Filesystem('view');
        $twig = new Twig_Environment($loader, [ 'cache' => false ]);
        echo $twig->render($view, $variables);
    }
}

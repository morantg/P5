<?php


class Controller{

    protected $viewPath;
    protected $template;

    protected function render($view, $variables = []){
        $loader = new Twig_Loader_Filesystem('view');
        $twig = new Twig_Environment($loader,[ 'cache' => false ]);
        echo $twig->render($view , $variables);
    }
}
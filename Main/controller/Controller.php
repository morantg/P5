<?php


class Controller{

    protected $viewPath;
    protected $template;

    protected function render($view, $variables = []){
        $loader = new Twig_Loader_Filesystem('view');
        $twig = new Twig_Environment($loader,[ 'cache' => false ]);
        echo $twig->render($view , $variables);
    }

    protected function forbidden(){
        header('HTTP/1.0 403 Forbidden');
        die('Acces interdit');
    }

    protected function notFound(){
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable');
    }

}
<?php
namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /**
     * @var BaseMiddleware[]
     */
    protected array $middleware = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    public function reder($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middleware[] = $middleware;
    }

    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }


}
<?php

namespace Mike4ip\Router;

/**
 * Class Router
 * @package Mike4ip\Router
 */
class Router
{
    /**
     * @var string
     */
    protected $request_string;

    /**
     * @var string
     */
    protected $controller_dir;

    /**
     * For beginners. Just start router without configuration
     * @param string $controller_dir
     * @return bool
     * @throws NotFoundException
     */
    public static function autorun(string $controller_dir): bool
    {
        ob_start();

        if(php_sapi_name() === "apache2handler" || php_sapi_name() === "fpm-fcgi" || php_sapi_name() === 'Kitten PHP')
            $route = $_SERVER['REQUEST_URI'];
        elseif(isset($_REQUEST['route']))
            $route = isset($_REQUEST['route']);
        else
            $route = '';

        $router = new Router($controller_dir, $route);
        $result = $router->getResult();
        $filename = $result->getController();
        unset($controller_dir, $router, $result);
        require($filename);
        return true;
    }

    /**
     * Router constructor.
     * @param string $controller_dir
     * @param string|null $request_string
     */
    public function __construct(string $controller_dir = '.', string $request_string = null)
    {
        $this->request_string = is_null($request_string) ? $_SERVER['REQUEST_URI'] : $request_string;
        $this->controller_dir = $controller_dir;
    }

    /**
     * @return Result
     */
    public function getResult(): Result
    {
        $route = $this->request_string;

        if(strpos($route, '?') !== false)
            $route = strstr($route, '?', true);

        if(strpos($route, '/') === 0)
            $route = substr($route, 1);

        if(!strlen($route))
            $route = 'index';

        $route = str_replace('.', '_', $route); // i am paranoid
        $result = new Result();
        $result->route = $route;
        $result->controller_dir = $this->controller_dir;
        return $result;
    }
}

<?php
namespace lib\router;

use lib\request\Request;
use lib\session\Session;
use lib\template\View;

/**
 * Class Route create route to application functionality
 *
 * @package lib\router
 */
class Route
{
    /**
     * Instance of class Request
     * @var Request
     */
    protected $request;

    public function __construct()
    {
        $this->request = new Request();

    }

    /**
     * Get route
     *
     * @param string $url
     * @param array $controllerMethod
     * $controllerMethod[0] The first element in the array is the path to the controller.
     * $controllerMethod[1] The second element in the array is the class method.
     * $controllerMethod[2] The third element in the array is the class method arguments.
     */
    public function get(string $url, array $controllerMethod)
    {
        if($this->request->method() !== 'GET' || $url !== $this->request->path() || empty($controllerMethod)) return;

        (new Session())->set('PREVIEWS_PAGE_URL', $this->request->createUrl($url));

        $this->compilation($controllerMethod, $this->request->get());
    }

    /**
     * Post route
     *
     * @param string $url
     * @param array $controllerMethod
     * $controllerMethod[0] The first element in the array is the path to the controller.
     * $controllerMethod[1] The second element in the array is the class method.
     * $controllerMethod[2] The third element in the array is the class method arguments.
     */
    public function post(string $url, array $controllerMethod)
    {
        if($this->request->method() !== 'POST' || $url !== $this->request->path() || empty($controllerMethod)) return;

        $this->compilation($controllerMethod, $this->request->post());
    }

    /**
     * Create page
     *
     * @param array $template
     * @param array $data
     */
    public function page(array $template, array $data = [])
    {
        (new View($template[0]))->render($template[1], $data);
    }

    /**
     * Compiling the functionality of the application
     *
     * @param array $controllerMethod
     * @param array $requestParameters
     */
    private function compilation(array $controllerMethod, array $requestParameters)
    {
        $className = $controllerMethod[0];

        $method = $controllerMethod[1]??'index';

        $arguments = $controllerMethod[2]??[];

        $argumentValues = [];

        foreach($arguments as $argumentName)
        {
            $argumentValues[] = $requestParameters[$argumentName]??'';
        }

        $newClass = new $className();

        call_user_func_array([$newClass, $method], $argumentValues);

        (new Session())->forget();

        die;
    }
}
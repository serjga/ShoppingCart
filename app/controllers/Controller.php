<?php
namespace app\controllers;

use lib\router\Router;

/**
 * Class Controller
 * @package app\controllers
 */
class Controller
{
    /**
     * Default class method for routing
     */
    public function index()
    {
        (new Router())->redirect('/');
    }
}
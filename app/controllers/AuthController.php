<?php
namespace app\controllers;

use app\services\Auth;
use lib\validator\Validator;
use lib\session\Session;
use lib\router\Router;

/**
 * Class AuthController
 *
 * @package app\controllers
 */
class AuthController extends Controller
{
    /**
     * Authenticate user
     *
     * @param $password
     * @param $email
     */
    public function login($password, $email)
    {
        $rules =
            [
                'password' => [ $password, 'notEmpty' ],
                'email' => [ $email, 'email' ]
            ];

        if(!(new Validator())->validation($rules))
        {
            (new Router())->back('E-mail or password is incorrect. Make sure that the data entered is correct.');
        }

        (new Auth())->authenticate($email, $password);

        (new Router())->back();
    }

    /**
     * Register user
     *
     * @param $login
     * @param $email
     * @param $password
     */
    public function register($login, $email, $password)
    {
        $rules =
            [
                'login' => [ $password, 'notEmpty' ],
                'password' => [ $password, 'notEmpty' ],
                'email' => [ $email, 'email' ]
            ];

        if(!(new Validator())->validation($rules))
        {
            (new Router())->back('Incorrect data entered. Please try again.');
        }

        $auth = new Auth();

        if(!($auth->register($login, $email, $password))) (new Router())->back($auth->errorMessage());

        (new Router())->back('You have successfully registered');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        (new Session())->delete('USER');

        (new Router())->redirect('/');
    }
}
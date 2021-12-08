<?php
namespace app\services;

use app\models\User;
use lib\session\Session;

/**
 * Class Auth manage users
 *
 * @package app\services
 */
class Auth
{
    /**
     * Session class instance
     * @var Session
     */
    protected $session;

    protected $errorMessage;

    function __construct()
    {
        $this->session = new Session();
    }

    /**
     * User authentication
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public function authenticate($email, $password)
    {
        if(empty($email) || empty($password))
        {
            return false;
        }

        $user = (new User())->checkAuthUser($email, $password);

        if(!empty($user))
        {
            $this->session->set('USER', $user);

            return true;
        }

        return false;
    }

    /**
     * Register new user
     *
     * @param $login
     * @param $email
     * @param $password
     * @param int $balance
     * @return bool
     */
    public function register($login, $email, $password, $balance = 100)
    {
        $this->error = false;

        $data = [];

        $data['email'] = $email;

        $data['name'] = $login;

        $data['password'] = md5($password);

        $data['balance'] = $balance;

        if((new User())->checkUser($email))
        {
            $this->errorMessage = 'A user with this email has already been created';

            return false;
        }

        if(!empty((new User())->create($data)))
        {
            $this->authenticate($email, $password);

            return true;
        }

        $this->errorMessage = 'Failed to register user';

        return false;
    }

    /**
     * Check authenticated user
     *
     * @return bool
     */
    public function check()
    {
        if($this->session->has('USER')) return true;
        return false;
    }

    /**
     * Get authenticated user model
     * @return mixed
     */
    public function user()
    {
        $user = (new Session())->get('USER');

        if(!empty($user)) return $user;

        return new class(){};
    }

    public function errorMessage()
    {
        return $this->errorMessage;
    }
}
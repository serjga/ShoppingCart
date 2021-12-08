<?php
namespace lib\session;

/**
 * Class Session
 * @package lib\session
 */
class Session
{
    /**
     * Get session
     *
     * @param string $sessionKey
     * @return mixed
     */
    public function get(string $sessionKey)
    {
        return $_SESSION[$sessionKey];
    }

    /**
     * Checking for the presence of a session
     * @param string $sessionKey
     * @return bool
     */
    public function has(string $sessionKey)
    {
        if(!isset($_SESSION[$sessionKey])) return false;

        return true;
    }

    /**
     * Remove session
     * @param string $sessionKey
     */
    public function delete(string $sessionKey)
    {
        unset($_SESSION[$sessionKey]);
    }

    /**
     * Set session
     *
     * @param string $sessionKey
     * @param $sessionValue
     */
    public function set(string $sessionKey, $sessionValue)
    {
        $_SESSION[$sessionKey] = $sessionValue;
    }

    /**
     * Set the lifetime of the session in one request
     *
     * @param string $sessionKey
     * @param $sessionValue
     */
    public function setTemporary(string $sessionKey, $sessionValue)
    {
        if(empty($sessionValue)) return;

        if(empty($_SESSION['TEMPORARY_SESSION'])) $_SESSION['TEMPORARY_SESSION'] = [];

        $_SESSION['TEMPORARY_SESSION'][$sessionKey] = $sessionValue;
    }

    /**
     * Check session with lifetime in one request
     *
     * @param $sessionKey
     * @return bool
     */
    public function hasTemporary(string $sessionKey)
    {
        if(!isset($_SESSION['TEMPORARY_SESSION']) || empty($_SESSION['TEMPORARY_SESSION'][$sessionKey])) return false;
        return true;
    }

    /**
     * Get session with lifetime in one request
     *
     * @param string $sessionKey
     * @return mixed
     */
    public function getTemporary(string $sessionKey)
    {
        return $_SESSION['TEMPORARY_SESSION'][$sessionKey];
    }

    /**
     * Remove session with lifetime in one request
     *
     * @param null|string $sessionKey
     * null - delete all temporary sessions
     * string - delete temporary sessions by key
     */
    public function forget($sessionKey = null)
    {
        if(!empty($sessionKey)) unset($_SESSION['TEMPORARY_SESSION'][$sessionKey]);

        else unset($_SESSION['TEMPORARY_SESSION']);
    }
}
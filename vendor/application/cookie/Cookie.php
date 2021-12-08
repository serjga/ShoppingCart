<?php
namespace lib\cookie;

/**
 * Class Cookie for working with cookies
 *
 * @package lib\cookie
 */
class Cookie
{
    /**
     * Get cookie
     *
     * @param string $name cookie name
     * @param null|true $json use if cookie value in json
     * @return array|string
     */
    public function getCookie(string $name, $json = null)
    {
        $cookie = trim($_COOKIE[$name])??'';

        if(empty($json)) return htmlspecialchars($cookie);

        $result = [];

        $cookieList = json_decode($cookie, true);

        if(!empty($cookieList)) foreach($cookieList as $key => $value)
            $result[htmlspecialchars(trim($key))] = htmlspecialchars(trim($value));

        return $result;
    }

    /**
     * Remove cookie
     *
     * @param string $name cookie name
     */
    public function delete($name)
    {
        unset($_COOKIE[$name]);

        setcookie($name, null, -1, '/');
    }
}
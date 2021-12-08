<?php
namespace lib\router;

use lib\config\Config;
use lib\router\Route;
use lib\session\Session;

/**
 * Class Router of the application
 *
 * @package lib\router
 */
class Router
{
    /**
     * Router constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Connect the file with routes
     */
    public function configure()
    {
        include_once (new Config('files'))->get('routes');
    }

    /**
     * Redirect to previews page
     *
     * @param null|string $message
     */
    public function back($message = null)
    {
        if(!empty($message))
        {
            (new Session())->setTemporary(
                'message',
                $message
            );
        }

        header("Location: " . $_SESSION['PREVIEWS_PAGE_URL']);
        exit;
    }

    /**
     * Redirect to page
     * @param $url
     */
    public function redirect($url)
    {
        header("Location: " . ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $url);
        exit;
    }
}
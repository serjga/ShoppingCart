<?php
namespace lib\router;

use DateTimeZone;
use lib\router\Router;

/**
 * Class App
 *
 * @package lib\router
 */
class App
{
    /**
     * App constructor.
     */
    function __construct()
    {
        date_default_timezone_set(DateTimeZone::listIdentifiers(DateTimeZone::UTC)[0]);
    }

    /**
     * Run application
     */
    public function run() {
        (new Router())->configure();
    }
}
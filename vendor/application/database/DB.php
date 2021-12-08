<?php
namespace lib\database;

use lib\config\Config;

/**
 * Class DB use database
 *
 * @package lib\database
 */

class DB
{
    /**
     * Application config database type
     *
     * @var array|string
     */
    private $db;

    /**
     * DB constructor.
     */
    function __construct()
    {
        $this->db = (new Config('config'))->get('database');
    }

    /**
     * Connect db
     *
     * @param null|string $db database type
     * @return Database
     */
    public function connection($db = null)
    {
        if(empty($db)) $db = $this->db;

        if($db === 'mysql') return new MySQL();

        return null;
    }
}
<?php
namespace app\models;

use lib\database\DB;

/**
 * Class Model
 *
 * @package app\models
 */
class Model
{
    protected $table;

    protected $db;

    /**
     * Model constructor.
     */
    public function __construct() {

        $this->db = (new DB())->connection();
    }
}
<?php
namespace lib\database;

/**
 * Interface Database
 *
 * @package lib\database
 */
interface Database
{
    /**
     * Setting the database configuration
     */
    public function config();

    /**
     * Connect database
     *
     * @return $this
     */
    public function connection();

    /**
     * Get database error
     *
     * @return mixed
     */
    public function error();

    /**
     * Prepare a database query
     *
     * @param string $sqlString
     * @return $this
     */
    public function query(string $sqlString);

    /**
     * Set a table for executing
     *
     * @param string $tableName
     * @return $this
     */
    public function table(string $tableName);

    /**
     * Set columns
     *
     * @param array $columns
     * @return $this
     */
    public function select(array $columns);

    /**
     * Prepare a query to the database to get data with a column value corresponding to multiple values
     *
     * @param string $columnName
     * @param array $values
     * @return $this
     */
    public function whereIn(string $columnName, array $values);

    /**
     * To prepare a query to the database to get data with the column value satisfying the condition
     *
     * @param string $columnName
     * @param string $condition
     * @param string $value
     * @return $this
     */
    public function where(string $columnName, string $condition, string $value);

    /**
     * To prepare a query to retrieve data from adjacent tables
     *
     * @param string $tableName
     * @param array $on
     * @return $this
     */
    public function leftOuterJoin(string $tableName, array $on);

    /**
     * Get a entry list of database
     *
     * @param bool $array
     * @return mixed
     */
    public function list(bool $array = false);

    /**
     * Get one entry from the database
     *
     * @param bool $array
     * @return bool|object
     */
    public function one($array = false);

    /**
     * Get the id of the last inserted entry
     *
     * @return mixed
     */
    public function last();

    /**
     * Insert entry
     *
     * @param array $values
     * @return $this|int
     */
    public function insert(array $values);

    /**
     * Bulk insert entries
     *
     * @param array $values
     * @return int
     */
    public function massInsert(array $values);

    /**
     * Updating entries
     *
     * @param array $values
     * @return int
     */
    public function update(array $values);
}
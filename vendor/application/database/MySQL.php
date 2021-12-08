<?php
namespace lib\database;

use lib\config\Config;
use PDO;

/**
 * Class MySQL for working with a MySQL database
 *
 * @package lib\database
 */
class MySQL implements Database
{
    protected $host;

    protected $database;

    protected $user;

    protected $password;

    protected $port;

    protected $charset;

    protected $pdo;

    protected $sql;

    protected $resource;

    protected $select;

    protected $sqlString;

    protected $where = [];

    protected $whereIn = [];

    protected $join = [];

    public function __construct()
    {
        $this->config();

        $this->connection();
    }

    /**
     * Setting the database configuration
     */
    public function config()
    {
        $config = new Config("database");

        $config = $config->get("mysql");

        $this->host = $config['host'];

        $this->database = $config['database'];

        $this->user = $config['user'];

        $this->password = $config['password'];

        $this->port = $config['port']??3306;

        $this->charset = $config['charset']??'utf8';
    }

    /**
     * Connect database
     *
     * @return $this
     */
    public function connection()
    {

        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $this->user, $this->password, $opt);

        return $this;
    }

    /**
     * Get database error
     *
     * @return mixed
     */
    public function error()
    {
        return $this->pdo->connect_errno;
    }

    /**
     * Preparing SQL query
     */
    protected function createSelectSql()
    {
        if(!empty($this->resource))
        {
            $variables = [];

            $this->sqlString = 'SELECT ' . ($this->select??'*') . ' FROM `' . $this->resource . '`';

            $this->createSqlJoin();

            $sqlWhere = '';

            $this->createSqlWhereIn($variables, $sqlWhere);

            $this->createSqlWhere($variables, $sqlWhere);

            $this->sqlString .= $sqlWhere;

            $this->sql = $this->pdo->prepare($this->sqlString);

            $this->sql->execute($variables);
        }
    }

    /**
     * Create SQL query using where in
     *
     * @param array $variables
     * @param string $sqlWhere
     */
    protected function createSqlWhereIn(array &$variables, string &$sqlWhere)
    {
        if($this->whereIn)
        {
            foreach($this->whereIn as $columnName => $whereIn)
            {
                $in  = str_repeat('?,', count($whereIn) - 1) . '?';

                if(!empty($sqlWhereIn)) $sqlWhere .= ' AND ';

                $sqlWhere .= " WHERE $columnName IN ($in)";

                $variables = array_merge($variables, $whereIn);
            }
        }
    }

    /**
     * Create SQL query using join
     */
    protected function createSqlJoin()
    {
        if(!empty($this->join))
        {
            $sqlJoin = '';

            foreach($this->join as $joinType => $tableKeys)
            {
                foreach ($tableKeys as $tableName => $tableKey)
                {
                    $sqlJoin .= " $joinType $tableName ON $tableKey[0] = $tableKey[1]";
                }
            }

            $this->sqlString .= $sqlJoin;
        }
    }

    /**
     * Create SQL query using where
     *
     * @param $variables
     * @param $sqlWhere
     */
    protected function createSqlWhere(array &$variables, string &$sqlWhere)
    {
        if(!empty($this->where))
        {
            $arrWhere = [];

            foreach($this->where as $condition)
            {
                if(empty($sqlWhere)) $sqlWhere .= " WHERE";
                else $sqlWhere .= " AND";

                $sqlWhere .= " $condition[0]$condition[1]?";

                $arrWhere[] = $condition[2];
            }

            $variables = array_merge($variables, $arrWhere);
        }
    }

    /**
     * Set a table for executing a SQL query
     *
     * @param string $tableName
     * @return $this
     */
    public function table(string $tableName)
    {
        $this->resource = $tableName;

        $this->select = null;

        return $this;
    }

    /**
     * Set table columns for SQL query execution
     *
     * @param array $columns
     * @return $this
     */
    public function select(array $columns)
    {
        $this->select = implode(', ', $columns);

        return $this;
    }

    /**
     * Prepare SQL query
     *
     * @param string $sqlString
     * @param array $variables
     * @return $this
     */
    public function query(string $sqlString, array $variables = [])
    {
        $this->sqlString = $sqlString;

        $this->sql = $this->pdo->prepare($this->sqlString);

        $this->sql->execute($variables);

        return $this;
    }

    /**
     * Prepare SQL query with WHERE IN
     *
     * @param string $columnName
     * @param array $values
     * @return $this
     */
    public function whereIn(string $columnName, array $values)
    {
        $this->whereIn[$columnName] = $values;

        return $this;
    }

    /**
     * Prepare SQL query with WHERE
     *
     * @param string $columnName
     * @param string $condition
     * @param string $value
     * @return $this
     */
    public function where(string $columnName, string $condition, string $value)
    {
        $this->where[] = [ $columnName, $condition, $value ] ;

        return $this;
    }

    /**
     * Prepare SQL query with LEFT OUTER JOIN
     *
     * @param string $tableName
     * @param array $on
     * @return $this
     */
    public function leftOuterJoin(string $tableName, array $on)
    {
        $join = 'LEFT OUTER JOIN';

        return $this->join($join, $tableName, $on);
    }

    /**
     * Create join SQL string
     *
     * @param string $join
     * @param string $tableName
     * @param array $on
     * @return $this
     */
    protected function join(string $join, string $tableName, array $on)
    {
        if(!isset($this->join[$join])) $this->join[$join] = [];

        $this->join[$join][$tableName] = [];

        foreach ($on as $innerKey => $outerKey)
        {
            $this->join[$join][$tableName] = [];

            $this->join[$join][$tableName][] = $innerKey;

            $this->join[$join][$tableName][] = $outerKey;
        }

        return $this;
    }

    /**
     * Get a entry list of data
     *
     * @param bool $array
     * @return mixed
     */
    public function list(bool $array = false)
    {
        $this->createSelectSql();

        $this->resource = null;

        $this->sqlString = null;

        $this->select = null;

        if(!$array) return $this->sql->fetchAll(PDO::FETCH_CLASS);

        return $this->sql->fetchAll();
    }

    /**
     * Get one entry from the database
     *
     * @param bool $array
     * @return bool|object
     */
    public function one($array = false)
    {
        $this->createSelectSql();

        $this->resource = null;

        $this->sqlString = null;

        $this->select = null;

        $row = $this->sql->fetch();

        if(!$row || $row['scalar'] === false) return false;

        if(!$array) $row = (object)$row;

        return $row;
    }

    /**
     * Get the id of the last inserted entry
     *
     * @return mixed
     */
    public function last()
    {
        $sql = $this->pdo->query("SELECT LAST_INSERT_ID()");

        $result = $sql->fetch(PDO::FETCH_ASSOC);

        return $result['LAST_INSERT_ID()'];
    }

    /**
     * Insert entry
     *
     * @param array $values
     * @return $this|int
     */
    public function insert(array $values)
    {
        if(empty($this->resource) || empty($values)) return 0;

        $columns = array_keys($values);

        $sql = $this->pdo->prepare("INSERT INTO " . $this->resource .
            " (`" . implode('`, `', $columns) . "`) VALUES (:" . implode(', :', $columns) . ")");

        $data = [];

        foreach($values as $column => $value)
        {
            $data[$column] = $value;
        }

        $sql->execute($data);

        return $this;
    }

    /**
     * Bulk insert entries
     *
     * @param array $values
     * @return int
     */
    public function massInsert(array $values): int
    {
        if(empty($this->resource) || empty($values)) return 0;

        $columns = array_keys($values[0]);

        $this->sqlString = "INSERT INTO " . $this->resource . " (`" . implode('`, `', $columns) . "`) VALUES ";

        $data = [];

        $arrDataStr = [];

        for($i = 0; $i < count($values); $i++)
        {
            $k = 1;

            $dataStr = "(";

            foreach($values[$i] as $column => $value)
            {
                $key = $column . '_' . $i . '_' . $k;

                $coma = ($k === 1) ? '' : ',';

                $data[$key] = $value;

                $dataStr .= $coma . ":" . $key ;

                $k++;
            }
            $dataStr .= ")";

            $arrDataStr[] = $dataStr;
        }

        $this->sqlString .= implode(', ', $arrDataStr);

        $sql = $this->pdo->prepare($this->sqlString);

        $sql->execute($data);

        return 1;
    }

    /**
     * Updating entries
     *
     * @param array $values
     * @return int
     */
    public function update(array $values): int
    {
        $variables = [];

        $this->sqlString = "UPDATE " . $this->resource . " SET ";

        foreach($values as $column => $value)
        {
            $variables[] = $value;
            $this->sqlString .= "$column=?";
        }

        $sqlWhere = '';

        $this->createSqlWhereIn($variables, $sqlWhere);

        $this->createSqlWhere($variables, $sqlWhere);

        $this->sqlString .= $sqlWhere;

        $sql = $this->pdo->prepare($this->sqlString);

        $sql->execute($variables);

        return 1;
    }
}
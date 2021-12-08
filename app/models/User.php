<?php
namespace app\models;

use lib\database\Database;
use lib\database\MySQL;

/**
 * Class User
 *
 * @package app\models
 */
class User extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Get user by email and password
     *
     * @param string $email
     * @param string $password
     * @return bool|object
     */
    public function checkAuthUser(string $email, string $password)
    {
        $passwordHash = md5($password);
        if(empty($row = $this->db->table($this->table)
            ->select(['users.*'])
            ->where('email', '=', $email)
            ->where('password', '=', $passwordHash)
            ->one())
        ) return false;

        return $row;
    }

    /**
     * Check user by email
     *
     * @param string $email
     * @return mixed
     */
    public function checkUser(string $email)
    {
        return $this->db->table($this->table)
            ->select(['users.id'])
            ->where('email', '=', $email)
            ->list();
    }

    /**
     * Find users by conditions
     *
     * @param array $conditions
     */
    public function find(array $conditions)
    {
        $this->db->table($this->table);

        foreach($conditions as $condition)
        {
            $this->db->where($condition[0], $condition[1], $condition[2]);
        }
        $this->db->list();
    }

    /**
     * Create user
     *
     * @param array $data
     * @return int|null
     */
    public function create($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    /**
     * Update user
     *
     * @param array $data
     * @param array $where
     * $where[0] - table column
     * $where[1] - condition
     * $where[2] - column value
     */
    public function update(array $data, array $where)
    {
        $this->db->table($this->table)->where($where[0], $where[1], $where[2])->update($data);
    }
}
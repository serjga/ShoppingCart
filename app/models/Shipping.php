<?php
namespace app\models;

/**
 * Class Shipping
 *
 * @package app\models
 */
class Shipping extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'shipping';

    /**
     * Get shipping methods
     * @return mixed
     */
    public function shippingMethods()
    {
        return $this->db->table($this->table)->list();
    }

    /**
     * Get shipping method by id
     * @param $shippingMethodId
     * @return object
     */
    public function shippingMethod($shippingMethodId): object
    {
        return $this->db->table($this->table)->where('id', '=', $shippingMethodId)->one();
    }
}
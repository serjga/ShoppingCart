<?php
namespace app\models;

use app\services\Auth;

/**
 * Class Product
 *
 * @package app\models
 */
class Product extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Get all products
     *
     * @return mixed
     */
    public function getProducts()
    {
        $userId = (int) ((new Auth())->user()->id??0);

        return $this->db->query(
            'SELECT products.*, images.name AS image, units.name AS unit, units.abbreviations AS abbreviation, units.type AS unit_type, ' .
            '(SELECT AVG(grade) as grade FROM product_rating WHERE product_rating.product_id=products.id) AS rating, ' .
            '(SELECT user_id FROM product_rating WHERE product_rating.product_id=products.id AND product_rating.user_id=?) AS voice ' .
            'FROM products LEFT OUTER JOIN images ON products.id = images.product_id ' .
            'LEFT OUTER JOIN units ON products.unit_id = units.id',
            [$userId]
        )->list();
    }

    /**
     * Get products by id list
     *
     * @param $ids
     * @return mixed
     */
    public function getProductsById($ids)
    {
        return $this->db->table($this->table)
            ->select(['products.*','images.name AS image', 'units.name AS unit', 'units.abbreviations AS abbreviation', 'units.type AS unit_type' ])
            ->leftOuterJoin('images', ['products.id' => 'images.product_id'])
            ->leftOuterJoin('units', ['products.unit_id' => 'units.id'])
            ->whereIn('products.id', $ids)
            ->list();
    }
}
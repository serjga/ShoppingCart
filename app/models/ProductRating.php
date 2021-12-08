<?php
namespace app\models;

/**
 * Class ProductRating
 *
 * @package app\models
 */
class ProductRating extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'product_rating';

    /**
     * Get product rating by user_id and product_id
     *
     * @param $productId
     * @param $userId
     * @return bool|object
     */
    public function getProductRating($productId, $userId)
    {
        return $this->db->table($this->table)
            ->where('product_id', '=', $productId)
            ->where('user_id', '=', $userId)
            ->one();
    }

    /**
     * Update product rating
     *
     * @param int $productId
     * @param int $userId
     * @param int $grade
     */
    public function updateProductRating(int $productId, int $userId, int $grade)
    {
        $this->db->table($this->table)
            ->where('product_id', '=', $productId)
            ->where('user_id', '=', $userId)
            ->update(['grade' => $grade]);
    }

    /**
     * Create product rating for user
     * @param int $productId
     * @param int $userId
     * @param int $grade
     * @return int|null
     */
    public function createProductRating(int $productId, int $userId, int $grade)
    {
        $data =
            [
                'product_id' => $productId,
                'user_id' => $userId,
                'grade' => $grade
            ];

        return $this->db->table($this->table)->insert($data);
    }
}
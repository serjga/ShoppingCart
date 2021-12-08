<?php
namespace app\services;

use app\models\ProductRating as ProductRatingModel;
use app\models\Product;
use app\models\Shipping;
use app\models\User;
use lib\cookie\Cookie;
use lib\session\Session;

/**
 * Class ProductRating
 *
 * @package app\services
 */
class ProductRating
{
    /**
     * Product rating by user
     *
     * @param int $productId
     * @param int $userId
     * @param int $grade from 1 to 5
     */
    public function userProductRating(int $productId, int $userId, int $grade)
    {
        $ratingModel = new ProductRatingModel();

        $rating = $ratingModel->getProductRating($productId, $userId);

        if($rating) $ratingModel->updateProductRating($productId, $userId, $grade);
        else $ratingModel->createProductRating($productId, $userId, $grade);
    }
}
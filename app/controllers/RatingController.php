<?php
namespace app\controllers;

use app\services\Auth;
use app\services\ProductRating;
use lib\response\Response;

/**
 * Class RatingController
 *
 * @package app\controllers
 */
class RatingController extends Controller
{
    /**
     * Rate the item by the user
     *
     * @param integer $productId
     * @param integer $grade from 1 to 5
     */
    public function estimate(int $productId, int $grade)
    {
        if(!empty($user = (new Auth())->user()))
        {
            (new ProductRating())->userProductRating($productId, $user->id, $grade);

            (new Response())->success();
        }
        else
        {
            (new Response())->success(['error' => 'User not logged in']);
        }
    }
}
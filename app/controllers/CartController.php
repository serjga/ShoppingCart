<?php
namespace app\controllers;

use app\services\ShoppingCart;
use lib\response\Response;
use lib\template\View;

/**
 * Class CartController
 *
 * @package app\controllers
 */
class CartController extends Controller
{
    /**
     * Cart page
     */
    public function index()
    {
        $shoppingCart = new ShoppingCart();

        (new View('layout'))->render('pages.cart', [
            'title' => 'My cart',
            'products' => $shoppingCart->products(),
            'totalAmount' => $shoppingCart->totalAmount()
        ]);
    }

    /**
     * Products in cart
     */
    public function cartProduct()
    {
        $shoppingCart = new ShoppingCart();

        $data =
            [ 'data' =>
                [
                    'products' => $shoppingCart->products(),
                    'totalAmount' => $shoppingCart->totalAmount()
                ]
            ];

        (new Response())->success($data);
    }
}
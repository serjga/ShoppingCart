<?php
namespace app\controllers;

use app\models\Shipping;
use app\services\Auth;
use app\services\ShoppingCart;
use lib\session\Session;
use lib\template\View;
use lib\router\Router;

/**
 * Class CheckoutController
 *
 * @package app\controllers
 */
class CheckoutController extends Controller
{
    /**
     * Checkout page
     */
    public function index()
    {
        if(!((new Auth()))->check()) (new Router())->back();

        $shoppingCart = new ShoppingCart();

        if(!(new Session())->hasTemporary('SUCCESS_ORDER') && count($shoppingCart->products()) === 0)
            (new Router())->redirect('/cart');

        $shipping = new Shipping();

        (new View('layout'))->render('pages.checkout', [
            'title' => 'Checkout',
            'products' => $shoppingCart->products(),
            'totalAmount' => $shoppingCart->totalAmount(),
            'shipping' => $shipping->shippingMethods(),
        ]);
    }

    /**
     * Checkout
     *
     * @param $deliveryMethod
     */
    public function checkout($deliveryMethod)
    {
        $shoppingCart = new ShoppingCart();

        $user = (new Auth())->user();

        $orderId = $shoppingCart->checkout($user->id, $deliveryMethod, $user->balance);

        $orderDetails = $shoppingCart->getLastOrderInfo();

        $orderDetails['order_id'] = $orderId;

        (new Session())->setTemporary('SUCCESS_ORDER', $orderDetails);

        (new Router())->back();
    }
}
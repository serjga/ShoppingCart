<?php
namespace app\services;

use app\models\Order;
use app\models\Product;
use app\models\Shipping;
use app\models\User;
use lib\cookie\Cookie;
use lib\session\Session;

/**
 * Class ShoppingCart
 *
 * @package app\services
 */
class ShoppingCart
{
    protected $products = [];

    protected $totalAmount = 0;

    protected $newUserBalance;

    protected $userBalanceBeforePay;

    protected $deliveryCost;

    /**
     * ShoppingCart constructor.
     * Retrieving added items from the cookie to the cart.
     */
    function __construct()
    {
        $cartProductsCookie = (new Cookie())->getCookie('cartProducts', 1);

        if(!empty($cartProductsCookie))
        {
            $product = new Product();

            $products = $product->getProductsById(array_keys($cartProductsCookie));

            foreach ($products as $key => $product) {

                $products[$key]->{'quantity'} = $cartProductsCookie[$product->id] ?? 1;

                $products[$key]->{'sum'} = $product->price * $products[$key]->quantity;

                $this->products[] = $products[$key];

                $this->totalAmount += $products[$key]->{'sum'};
            }
        }
    }

    /**
     * Get products what was added to the cart.
     *
     * @return array
     */
    public function products(): array
    {
        return $this->products;
    }

    /**
     * Get the amount of items added to the cart.
     *
     * @return float
     */
    public function totalAmount(): float
    {
        return floatval($this->totalAmount);
    }

    /**
     * Checkout
     * @param $userId
     * @param $deliveryMethod
     * @param $userBalance
     * @return int order id
     */
    public function checkout($userId, $deliveryMethod, $userBalance): int
    {
        if( empty($userId) ||
            empty($deliveryMethod) ||
            count($this->products()) === 0 ||
            empty($shippingMethod = (new Shipping())->shippingMethod($deliveryMethod)) ||
        $this->totalAmount() + $shippingMethod->delivery_cost > $userBalance
        ) return false;

        $this->userBalanceBeforePay = $userBalance;

        $this->deliveryCost = $shippingMethod->delivery_cost;

        $data = [];
        $data['user_id'] = $userId;
        $data['shipping_id'] = $deliveryMethod;
        $data['user_balance'] = $this->userBalanceBeforePay;
        $data['products'] = [];

        foreach($this->products() as $product)
        {
            $data['products'][] = (array) $product;
        }

        $orderId = (new Order())->createOrder($data);

        $this->newUserBalance = $this->userBalanceBeforePay - $this->totalAmount() - $this->deliveryCost;

        (new User())->update(['balance' => $this->newUserBalance], ['id', '=', $userId]);

        $session = new Session();

        $user = $session->get('USER');

        $user->{'balance'} = $this->newUserBalance;

        if($session->has('USER')) $session->set('USER', $user);

        (new Cookie())->delete('cartProducts');

        return $orderId;
    }

    /**
     * Get info about last checkout
     *
     * @return array
     */
    public function getLastOrderInfo(): array
    {
        return [
            'user_balance_before_checkout' => $this->userBalanceBeforePay,
            'user_balance_after_checkout' => $this->newUserBalance,
            'delivery_cost' => $this->deliveryCost,
            'products_cost' => $this->totalAmount(),
            'total' => $this->deliveryCost + $this->totalAmount(),
        ];
    }
}
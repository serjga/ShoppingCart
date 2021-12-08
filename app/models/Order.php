<?php
namespace app\models;

/**
 * Class Order
 *
 * @package app\models
 */
class Order extends Model
{
    /**
     * Order table name
     *
     * @var string
     */
    protected $table = 'purchases';

    /**
     * Order products table name
     *
     * @var string
     */
    protected $purchaseProductTable = 'purchase_product';

    /**
     * Create order
     *
     * @param $data
     * @return mixed
     */
    public function createOrder($data)
    {
        $dataPurchase =
            [
                'user_id' => $data['user_id'],
                'shipping_id' => $data['shipping_id'],
                'user_balance' => $data['user_balance'],
            ];

        $purchaseId = $this->db->table($this->table)->insert($dataPurchase)->last();

        $dataProducts = [];

        foreach($data['products'] as $product)
        {
            $dataProducts[] =
                [
                    'purchase_id' => (integer)$purchaseId,
                    'product_id' => (integer)$product['id'],
                    'price' => (float)$product['price'],
                    'quantity' => (float)$product['quantity'],
                ];
        }

        $this->db->table($this->purchaseProductTable)->massInsert($dataProducts);

        return $purchaseId;
    }
}
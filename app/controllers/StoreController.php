<?php
namespace app\controllers;

use app\models\Product;
use lib\template\View;

/**
 * Class StoreController
 *
 * @package app\controllers
 */
class StoreController extends Controller
{
    /**
     * Catalog page
     */
    public function index()
    {
        $product = new Product();

        (new View('layout'))->render('pages.index', [
            'title' => 'Catalog',
            'products' => $product->getProducts()
        ]);
    }
}
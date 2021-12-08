<?php
$route = new lib\router\Route();

$route->get("/", [ "app\controllers\StoreController" ]);
$route->get("/cart", [ "app\controllers\CartController", "index", [] ]);
$route->get("/checkout", [ "app\controllers\CheckoutController", "index", [] ]);
$route->get("/checkout", [ "app\controllers\CheckoutController", "index", [] ]);
$route->get("/cart-products", [ "app\controllers\CartController", "cartProduct", [] ]);
$route->post("/user/login", [ "app\controllers\AuthController", "login", ['password','email'] ]);
$route->post("/user/register", [ "app\controllers\AuthController", "register", ['login','email','password'] ]);
$route->post("/user/logout", [ "app\controllers\AuthController", "logout"]);
$route->post("/checkout", [ "app\controllers\CheckoutController", "checkout", ['delivery-method']]);
$route->post("/product-evaluation", [ "app\controllers\RatingController", "estimate", ['productId', 'grade']]);

$route->page(['layout', 'pages.404']);


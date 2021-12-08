<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title><?= $title ?></title>

    <link href="css/corporate.css" rel="stylesheet">

    <link href="css/app.css" rel="stylesheet">

</head>

<body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="wrapper">

    <div class="main">

        <nav class="navbar navbar-expand navbar-light bg-white">
            <div class="container">
                <div class="col-6 text-left p-0 h4 m-0">
                    <ul class="p-0 m-0">
                        <li class="list-inline-item">
                            <a class="text-muted" href="/">Catalog</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 text-right p-0 h4 m-0 px-2">

                    <?php ($auth = new \app\services\Auth()) ?>

                    <?php if($auth->check()): ?>

                        <span class="h5 mt-2 mr-3 align-bottom usd-money" style="width: 50px;">
                            <?php echo $auth->user()->balance ?>
                        </span>

                    <?php endif; ?>

                    <img src="icons/user.svg" data-element="modal" data-group="user" class="hand mr-3" alt="Account" width="21" height="auto" style="margin-top: 3px;">
                    <div id="account-dropdown-menu" data-element="modal" class="dropdown-menu dropdown-menu-lg dropdown-menu-right over-substrate py-0" style="max-width: inherit">

                        <?php if($auth->check()): ?>

                            <form action="/user/logout" method="post">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative text-left">
                                        <?php echo $auth->user()->name ?>
                                    </div>
                                </div>
                                <div class="list-group">
                                    <div class="row no-gutters align-items-center p-3">
                                        <p class="w-100">Email: <?php echo $auth->user()->email ?></p>

                                        <p class="w-100">Balance: <span class="usd-money"><?php echo $auth->user()->balance ?></span></p>
                                    </div>

                                    <hr class="m-0">
                                </div>

                                <div class="dropdown-menu-footer">
                                    <button type="submit" class="btn btn-primary btn-sm float-right mb-3">Logout</button>
                                </div>
                            </form>

                        <?php else: ?>

                            <div class="p-2 border-bottom">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="position-relative">
                                            My account
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <div class="">
                                            <a class="text-primary btn disabled p-0" data-group="tab" data-tab="window-login" onclick="switchTab(this)">Login</a>
                                            <span>|</span>
                                            <a class="text-muted btn p-0" data-group="tab" data-tab="window-register" onclick="switchTab(this)">Register</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="window-login" data-window="tab" class="">
                                <form action="/user/login" method="post">
                                    <div class="list-group bg-light">

                                        <div class="row no-gutters align-items-center p-3">
                                            <label>Email</label>
                                            <input class="form-control form-control-sm mb-2" name="email" type="text" placeholder="Email" max="50">

                                            <label>Password</label>
                                            <input class="form-control form-control-sm mb-2" name="password" type="password" placeholder="Password">
                                        </div>

                                        <hr class="m-0">
                                    </div>

                                    <div class="dropdown-menu-footer">
                                        <button type="submit" class="btn btn-success btn-sm float-right mb-3">Login</button>
                                    </div>
                                </form>
                            </div>

                            <div id="window-register" data-window="tab" class="d-none">
                                <form action="/user/register" method="post">
                                    <div class="list-group bg-light">

                                        <div class="row no-gutters align-items-center p-3">
                                            <label>Name</label>
                                            <input class="form-control form-control-sm mb-2" name="login" type="text" placeholder="Name" max="50">

                                            <label>Email</label>
                                            <input class="form-control form-control-sm mb-2" name="email" type="email" placeholder="Email" max="50">

                                            <label>Password</label>
                                            <input class="form-control form-control-sm mb-2" name="password" type="password" placeholder="Password">
                                        </div>

                                        <hr class="m-0">
                                    </div>

                                    <div class="dropdown-menu-footer">
                                        <button type="submit" class="btn btn-primary btn-sm float-right mb-3">Register</button>
                                    </div>
                                </form>
                            </div>

                        <?php endif; ?>

                    </div>

                    <img src="icons/cart.svg" data-group="cart" class="hand" alt="My cart" width="25" height="auto">
                    <span data-cart="counter" class="indicator hand d-none" data-group="cart"></span>

                    <div id="cart-dropdown-menu" data-element="modal" class="dropdown-menu dropdown-menu-lg dropdown-menu-right over-substrate py-0">
                        <div class="dropdown-menu-header">
                            <div class="position-relative">
                                My purchases
                            </div>
                        </div>
                        <div id="cart-dropdown-menu-products" class="list-group">

                        </div>
                        <div class="dropdown-menu-footer">
                            <span id="product-cart-additional-items" class="text-muted float-left"></span>
                        </div>
                        <div class="dropdown-menu-footer">
                            <?php if($auth->check()): ?>
                                <a href="/checkout" class="btn btn-success btn-sm float-right mb-3">Checkout</a>
                            <?php else: ?>
                                <a class="btn btn-success btn-sm float-right mb-3 disabled">Checkout</a>
                            <?php endif; ?>
                            <a href="/cart" class="btn btn-primary btn-sm float-right mb-3 mr-3">Cart</a>
                        </div>
                    </div>
                </div>


            </div>
        </nav>

        <main class="content">

            <content></content>

        </main>

        <footer class="footer">
            <div class="container-fluid container">
                <div class="row text-muted">
                    <div class="col text-center">
                        <p class="mb-0">
                            &copy; 2021 - <a href="/" class="text-muted">Store</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<div id="substrate-layout" class="substrate d-none" onclick="hideModals()"></div>

<script src="js/app.js"></script>

<?php ($session = new \lib\session\Session()) ?>

<?php if($session->hasTemporary('message')): ?>

    <script>
        alert('<?php echo $session->getTemporary("message"); ?>');
    </script>

<?php endif; ?>
</body>

</html>
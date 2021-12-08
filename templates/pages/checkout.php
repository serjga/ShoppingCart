<div class="container-fluid container p-0">

    <h1 class="h3 mb-3">Checkout</h1>

    <?php $session = (new \lib\session\Session())?>

    <?php if($session->hasTemporary('SUCCESS_ORDER')): ?>

        <?php $sessionOrder = $session->getTemporary('SUCCESS_ORDER') ?>

        <div class="row">
            <div class="col-12">
                <div class="card h-auto mb-3">
                    <div class="card-body text-center">
                        <h3 class="float-center">Order #<?php echo $sessionOrder['order_id']??'' ?> completed successfully</h3>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-left">Order #<?php echo $sessionOrder['order_id']??'' ?> details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-left">
                                    <td>Product cost</td>
                                    <td class="text-right"><span class="usd-money"><?php echo $sessionOrder['products_cost']??0 ?></span></td>
                                </tr>
                                <tr class="text-left">
                                    <td>Delivery cost</td>
                                    <td class="text-right"><span class="usd-money"><?php echo $sessionOrder['delivery_cost']??0 ?></span></td>
                                </tr>
                                <tr class="text-left">
                                    <th>Total order</th>
                                    <th class="text-right"><span class="usd-money"><?php echo $sessionOrder['total']??0 ?></span></th>
                                </tr>
                                <tr class="text-left">
                                    <td>User balance before checkout</td>
                                    <td class="text-right"><span class="usd-money"><?php echo $sessionOrder['user_balance_before_checkout']??0 ?></span></td>
                                </tr>
                                <tr class="text-left">
                                    <td>User balance after checkout</td>
                                    <td class="text-right"><span class="usd-money"><?php echo $sessionOrder['user_balance_after_checkout']??0 ?></span></td>
                                </tr>
                            </tbody>
                        </table>

                        <a href="/" class="btn btn-secondary btn-block w-auto">Continue shopping</a>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="row">
            <div class="col-md-8 col-xl-8">
                <div class="card h-auto mb-3">
                    <div class="card-body">
                        <form action="/checkout" method="post">
                            <div class="">
                                <h5 class="card-title mb-3">Delivery method</h5>

                                <select class="form-control mb-3" onchange="switchDeliveryMethod(this)">
                                    <option value='' selected="">Сhoose delivery method...</option>

                                    <?php foreach($shipping as $shippingMethod): ?>

                                        <option value="<?php echo $shippingMethod->id ?>:<?php echo $shippingMethod->delivery_cost ?>">
                                            <?php echo $shippingMethod->name ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>
                            <input type="hidden" name="delivery-method" value="">
                            <div class="">
                                <button type="submit" class="btn btn-primary" data-button="pay" disabled>Pay for the order</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="col-md-4 col-xl-4">
                <div class="card h-auto">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order</h5>
                    </div>
                    <div class="card-body h-100">

                        <?php foreach($products as $product): ?>

                            <div class="media">
                                <img src="img/products/<?php echo $product->image ?>" width="50" height="" class="mr-2" alt="<?php echo $product->name ?>">
                                <div class="media-body">
                                    <span class="float-right text-dark usd-money"><?php echo $product->sum ?></span>
                                    <p class="first-letter-uppercase m-0"><?php echo $product->name ?></p>
                                    <small class="text-muted"><span class="usd-money"><?php echo $product->price ?></span>✕<?php echo $product->quantity ?></small><br />
                                </div>
                            </div>
                            <hr />

                        <?php endforeach; ?>

                        <div data-order="delivery-cost-box" class="media d-none">
                            <div class="media-body">
                                <strong class="text-muted h6">Delivery cost </strong>
                                <strong data-order="delivery-cost" class="float-right text-muted usd-money">0</strong>
                            </div>
                        </div>

                        <div class="media">
                            <div class="media-body">
                                <strong data-order="total-amount" data-total-amount="<?php echo $totalAmount ?>" class="float-right text-success usd-money"><?php echo $totalAmount ?></strong>
                                <strong>Total </strong> <br />
                            </div>
                        </div>

                        <hr />
                        <a href="/cart" class="btn btn-secondary btn-block">Modify order</a>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>
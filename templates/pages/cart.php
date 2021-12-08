<div class="container-fluid container p-0">
<h1 class="h3 mb-3">Cart</h1>
<div class="card h-auto">

    <div class="card-header">
        <h5 class="card-title">My order</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">

                <div id="full-cart" class="<?php if(count($products) === 0): ?>d-none<?php endif; ?>">

                    <table class="table">

                        <tbody>

                        <?php foreach($products as $product): ?>

                            <tr data-product-card="box" data-product="<?php echo $product->id ?>">
                                <td style="width:5%;">
                                    <img src="img/products/<?php echo $product->image ?>" width="50"
                                         class="mr-2" alt="<?php echo $product->name ?>">
                                </td>
                                <td class="first-letter-uppercase"><?php echo $product->name ?></td>
                                <td style="width:5%;"><span data-product="price" data-price="<?php echo $product->price ?>" class="usd-money"><?php echo $product->price ?></span></td>
                                <td style="width:5%;">✕</td>
                                <td class="d-none d-md-table-cell" style="width:15%;">
                                    <input type="number" class="textbox0 mbm form-control py-2 form-control-sm pr-1"
                                            <?php if($product->unit_type === 2):  ?> step="0.1" <?php endif; ?>
                                           data-unit-type="<?php echo $product->unit_type ?>" data-last-value="<?php echo $product->quantity ?>"
                                           data-product-units="quantity"
                                           min="1" value="<?php echo $product->quantity ?>" style="width: 80px;" data-cart="active"/>
                                </td>
                                <td style="width:5%;"><?php echo $product->unit ?></td>
                                <td style="width:5%;">=</td>
                                <td class="d-none d-md-table-cell" style="width:5%;"><span data-product="sum" data-product-sum="<?php echo $product->sum ?>" class="usd-money"><?php echo $product->sum ?></span>
                                </td>
                                <td class="table-action">
                                    <a class="float-right text-danger" data-cart-product="remove">✕</a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        <tr>
                            <th colspan="9">
                                <span class="float-right" >Total: <span data-purchase="total" class="usd-money"><?php echo $totalAmount ?></span></span>
                            </th>
                        </tr>

                        </tbody>

                    </table>

                    <a href="/" class="btn btn-primary float-left text-white" style="height: 31px;">
                        Continue shopping
                    </a>

                    <?php if($auth->check()): ?>

                        <a href="/checkout" class="btn btn-secondary float-right text-white" style="height: 31px;">
                            Checkout
                        </a>

                    <?php else: ?>

                        <a class="btn btn-secondary float-right text-white disabled" style="height: 31px;">
                            Checkout
                        </a>

                    <?php endif; ?>

                </div>

                <div id="empty-cart" class="w-100 text-center <?php if(count($products) > 0): ?> d-none<?php endif; ?>">

                    <img src="icons/cart.svg" alt="My is empty cart" width="150" height="auto">

                    <h3>Your cart is empty</h3>
                        <a href="/" class="btn btn-secondary text-white mt-5">
                            Continue shopping
                        </a>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
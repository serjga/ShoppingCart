<div class="container-fluid container p-0">

    <h1 class="h3 mb-3">Catalog</h1>

    <div class="row">

        <?php foreach($products as $product): ?>

            <div class="col-12 col-md-6 col-lg-3">

                <div class="card" data-group="product" data-product-id="<?php echo $product->id ?>">

                    <div class="card-header px-4 pt-4 pb-0">
                        <h5 class="card-title mb-0 align-left float-left first-letter-uppercase"><?php echo $product->name ?></h5>
                        <br>

                        <?php if($auth->check() && empty($product->voice)): ?>

                            <div class="rating-area rating-mini float-left px-0 d-none" data-product-rating="<?php echo $product->id ?>" onmouseout="hideProductRatingBar(this)">
                                <input type="radio" id="star-5-<?php echo $product->id ?>" name="rating" value="5">
                                <label for="star-5-<?php echo $product->id ?>" title="Grade «5»"></label>
                                <input type="radio" id="star-4-<?php echo $product->id ?>" name="rating" value="4">
                                <label for="star-4-<?php echo $product->id ?>" title="Grade «4»"></label>
                                <input type="radio" id="star-3-<?php echo $product->id ?>" name="rating" value="3">
                                <label for="star-3-<?php echo $product->id ?>" title="Grade «3»"></label>
                                <input type="radio" id="star-2-<?php echo $product->id ?>" name="rating" value="2">
                                <label for="star-2-<?php echo $product->id ?>" title="Grade «2»"></label>
                                <input type="radio" id="star-1-<?php echo $product->id ?>" name="rating" value="1">
                                <label for="star-1-<?php echo $product->id ?>" title="Grade «1»"></label>
                            </div>

                            <div class="rating-mini float-left px-0" data-rating="active" data-product-rating-bar="<?php echo $product->id ?>" onmouseover="showRatingBar(this)">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                    <span class="<?php if($i < $product->rating) echo 'active'; ?>" data-rating-star="<?php echo $i ?>"></span>
                                <?php endfor; ?>
                            </div>

                        <?php else: ?>

                            <div class="rating-mini float-left px-0">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                    <span class="<?php if($i < $product->rating) echo 'active'; ?>"></span>
                                <?php endfor; ?>
                            </div>

                        <?php endif; ?>

                    </div>
                    <div class="card-body px-4 pt-2" style="height: 250px;">
                        <img src="img/products/<?php echo $product->image ?>" class="mr-1"
                             alt="<?php echo $product->name ?>"  style="height: 150px;">
                        <p><?php echo $product->description ?></p>
                    </div>
                    <hr class="m-0">

                    <div class="card-body py-0" style="height:150px;">

                        <div class="row" style="height:70px;">
                            <div class="col-6 pr-0 mt-1 mb-0">
                                <span class="h4 text-dark float-right py-2 usd-money"><?php echo $product->price ?></span>

                            </div>
                            <div class="col-1" style="padding: 10px 3px 10px 3px ;">
                                <img src="icons/cross.svg" class="" width="14" height="auto">
                            </div>
                            <div class="col-5" style="padding: 10px 3px 10px 3px ;">
                                <input data-product-quantity="<?php echo $product->id ?>" type="number"
                                       <?php if($product->unit_type === 2):  ?> step="0.1" <?php endif; ?>
                                       class="textbox0 mbm form-control py-2 form-control-sm pr-1"
                                       data-unit-type="<?php echo $product->unit_type ?>" data-last-value="1"
                                       min="1" value="1" style="width: 80px;" data-product-units="quantity" />

                                <span class="h5 text-dark py-2"><?php echo $product->abbreviation ?></span>
                            </div>
                        </div>

                        <button class="btn btn-secondary float-left text-white" style="height: 31px;"
                                data-group="buy" onclick="addToCart(this)">
                            Add to cart <img src="icons/white_cart.svg" class="" alt="Add to cart" width="20" height="auto">
                        </button>

                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>
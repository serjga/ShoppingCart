/**
 * Show or hide modal window
 * @param selector 'DOM element selector'
 */
function showModal(selector)
{
    let el = $(selector);

    let substrate = $('#substrate-layout');

    if(el.hasClass('show'))
    {
        el.removeClass('show');

        substrate.addClass('d-none');
    }
    else
    {
        el.addClass('show');

        substrate.removeClass('d-none');
    }
}

/**
 * Hide modal windows
 */
function hideModals()
{
    let el = $('[data-element="modal"]');

    let substrate = $('#substrate-layout');

    el.each(function()
    {
        $(this).hasClass('show')
        {
            el.removeClass('show');
        }
    });

    if(!substrate.hasClass('d-none'))
    {
        substrate.addClass('d-none');
    }
}

/**
 * Get cookie by name
 * @param name
 */
function getCookie(name)
{
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

/**
 * Set cookie
 * @param name
 * @param value
 * @param options
 */
function setCookie(name, value, options = {})
{
    options =
    {
        path: '/',
        ...options
    };

    if (options.expires instanceof Date)
    {
        options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options)
    {
        updatedCookie += "; " + optionKey;

        let optionValue = options[optionKey];

        if (optionValue !== true)
        {
            updatedCookie += "=" + optionValue;
        }
    }

    document.cookie = updatedCookie;
}

/**
 * Remove cookie
 * @param name
 */
function deleteCookie(name)
{
    setCookie(name, "", {
        'max-age': -1
    })
}

/**
 * Add product to cart
 * @param el 'Add to cart button'
 */
function addToCart(el)
{
    let productId = el.closest('[data-group="product"]').dataset.productId??null;

    let productQuantity = el.closest('[data-group="product"]').querySelector('[data-product-units="quantity"]').value??null;

    if(productId === null || productQuantity === null)
    {
        alert('Failed to add the item to the cart');
        return;
    }

    let objCartProducts = getCartItemsFromCookie();

    objCartProducts[productId] = objCartProducts[productId]??0;

    objCartProducts[productId] = (objCartProducts[productId] * 1);

    productId = productId * 1;

    productQuantity = productQuantity * 1;

    if(productId in objCartProducts) objCartProducts[productId] += productQuantity;

    else objCartProducts[productId] = productQuantity;

    setCookie('cartProducts', JSON.stringify(objCartProducts), {'max-age': 24 * 3600});

    rewriteCart();

    document.querySelector('[data-product-quantity="' + productId + '"]').value = 1;

    alert('Item has been added to the cart');
}

/**
 * Update product cart
 * @param productId 'id of product'
 * @param productQuantity 'quantity of product'
 */
function updateCart(productId, productQuantity)
{
    let objCartProducts = getCartItemsFromCookie();

    objCartProducts[productId] = objCartProducts[productId] * 1;

    if(productId in objCartProducts) objCartProducts[productId] = productQuantity;

    else objCartProducts[productId] = productQuantity;

    setCookie('cartProducts', JSON.stringify(objCartProducts), {'max-age': 24 * 3600});
}

/**
 * Get products id and quantity from cookie
 * @returns {{}}
 */
function getCartItemsFromCookie()
{
    let objCartProducts = {}

    let jsonCartProducts = getCookie('cartProducts');

    if(jsonCartProducts !== undefined) objCartProducts = JSON.parse(jsonCartProducts);

    return objCartProducts;
}

/**
 * Switch delivery method
 * @param el
 */
function switchDeliveryMethod(el)
{
    let deliveryMethodValue = el.value;

    let totalBox = $('[data-order="total-amount"]');

    let total = ((totalBox.data('totalAmount') ?? 0));

    if(deliveryMethodValue === '')
    {
        $('[data-button="pay"]').attr( "disabled", true);

        $('input[name="delivery-method"]').val('');

        $('[data-order="delivery-cost-box"]').addClass('d-none');

        totalBox.text(total);

        $('[data-order="delivery-cost"]').text(0);
    }
    else
    {
        $('[data-button="pay"]').removeAttr('disabled');

        let arrDeliveryValue = deliveryMethodValue.split(':');

        $('input[name="delivery-method"]').val(arrDeliveryValue[0]);

        $('[data-order="delivery-cost-box"]').removeClass('d-none');

        let deliveryCost = (arrDeliveryValue[1]??0) * 1;

        totalBox.text(total + deliveryCost);

        $('[data-order="delivery-cost"]').text(deliveryCost);
    }
    moneyFormat();
}

/**
 * Update cart items count
 */
function rewriteCart()
{
    let objCartProducts = getCartItemsFromCookie();

    let itemsInCart = Object.keys(objCartProducts).length;

    let elCartItemsCount = '[data-cart="counter"]';

    getCartProducts();

    if(itemsInCart > 0)
    {
        $('[data-cart="counter"]').text(itemsInCart);

        show(elCartItemsCount);
    }
    else
    {
        hide(elCartItemsCount);
    }
}

/**
 * Hide element
 * @param selector 'css selector'
 */
function hide(selector)
{
    let el = $(selector);

    if(!el.hasClass('d-none')) el.addClass('d-none');
}

/**
 * Show element
 */
function show(selector)
{
    let el = $(selector);

    if(el.hasClass('d-none')) el.removeClass('d-none');
}

/**
 * Switch tab elements
 * @param el
 */
function switchTab(el)
{
    $("[data-window='tab']").each(
        function()
        {
            if(!$(this).hasClass('d-none') && el.dataset.tab !== $(this).attr('id')) $(this).addClass('d-none');

            if($(this).hasClass('d-none') && el.dataset.tab === $(this).attr('id')) $(this).removeClass('d-none');
        }
    );

    let group = el.dataset.group;

    $("[data-group='" + group + "']").each(function()
    {
        if(el.dataset.tab !== $(this).data('tab'))
        {
            $(this).removeClass('disabled');
            $(this).removeClass('text-primary');
            $(this).addClass('text-muted');
        }

        if(el.dataset.tab === $(this).data('tab'))
        {
            $(this).addClass('disabled');
            $(this).addClass('text-primary');
            $(this).removeClass('text-muted');
        }
    });
}

/**
 * Rewrite total of the cart
 */
function rewriteTotalCard()
{
    let totalAmount = 0;

    let productSum = document.querySelectorAll('[data-product="sum"]');

    productSum.forEach(function(e)
    {
        totalAmount += e.dataset.productSum * 1;
    });

    $('[data-purchase="total"]').text(totalAmount);
}

/**
 * Remove product from cookie
 * @param productId
 * @returns {number}
 */
function removeCartPositionCookie(productId)
{
    let objCartProducts = getCartItemsFromCookie();

    if(productId in objCartProducts) delete objCartProducts[productId];

    let arrCookie = Object.keys(objCartProducts);

    if(arrCookie.length > 0) setCookie('cartProducts', JSON.stringify(objCartProducts), {'max-age': 24 * 3600});

    else deleteCookie('cartProducts');

    return arrCookie.length;
}

/**
 * Show empty cart
 */
function switchEmptyCart()
{
    $('#full-cart').addClass('d-none');

    $('#empty-cart').removeClass('d-none');
}

/**
 * Show money format
 */
function moneyFormat()
{
    $('.usd-money').each(function()
    {
        $(this).text(parseFloat($(this).text()).toFixed(2));
    });
}

/**
 * Estimate
 * @param productId
 * @param grade
 */
function estimate(productId, grade)
{
    document.querySelectorAll('[data-rating="selected"]').forEach(function(e)
    {
        if(e.dataset.productRatingBar*1 !== productId*1)
        {
            let ratingBar = document.querySelector('[data-product-rating-bar="' + e.dataset.productRatingBar + '"]');

            let mustHideEl = document.querySelector('[data-product-rating="' + e.dataset.productRatingBar + '"]');

            ratingBar.dataset.rating = 'disabled';

            if(!e.classList.contains('d-none')) e.classList.add('d-none');

            if(!mustHideEl.classList.contains('d-none')) mustHideEl.classList.add('d-none');

            ratingBar.classList.remove('d-none');
        }
    });

    document.querySelectorAll('[data-product-rating-bar="' + productId + '"] span').forEach(function(e)
    {
        if(grade*1 > e.dataset.ratingStar*1)
        {
            if(e.dataset.activeStar !== 'yes') e.dataset.activeStar = 'yes';
        }
        else
        {
            if(e.dataset.activeStar === 'yes') e.dataset.activeStar = 'no';
        }
    });

    $.ajax({
        url: "/product-evaluation",
        method: "POST",
        data: {
            productId : productId ,
            grade : grade
        },
        beforeSend: function( xhr ) {
            document.querySelectorAll('[data-product-rating-bar="' + productId + '"] span').forEach(function(e) {
                if(grade*1 > e.dataset.ratingStar*1)
                {
                    if(e.dataset.activeStar === 'yes') e.classList.add('active');
                }
                else
                {
                    if(e.dataset.activeStar !== 'yes') e.classList.remove('active');
                }
            })
        },
        dataType: 'json',
    }).done(function( data ) {
        document.querySelector('[data-product-rating-bar="' + productId + '"]').dataset.rating = 'selected';
    });
}

/**
 * Show rating bar with active stars
 * @param el
 */
function showRatingBar(el)
{
    if(el.dataset.rating === 'active' || el.dataset.rating === 'selected')
    {
        let productId = el.dataset.productRatingBar;

        if(!el.classList.contains('d-none')) el.classList.add('d-none');

        document.querySelector('[data-product-rating="' + productId + '"]').classList.remove('d-none');
    }
}

/**
 * Hide rating bar with active stars
 * @param el
 */
function hideProductRatingBar(el)
{
    let productId = el.dataset.productRating;

    if(!el.classList.contains('d-none')) el.classList.add('d-none');

    document.querySelector('[data-product-rating-bar="' + productId + '"]').classList.remove('d-none');
}

/**
 * Get cart products data
 */
function getCartProducts()
{
    $.ajax({
        url: "/cart-products",
        method: "GET",
        beforeSend: function( xhr )
        {
            document.getElementById('cart-dropdown-menu-products').innerHTML = '';
        },
        dataType: 'json',
    }).done(function(res)
    {
        if(res.data.products.length > 0)
        {
            for(let i=0; i < 3; i++)
            {
                if('object' === typeof res.data.products[i])
                {
                    createCartProductItem(res.data.products[i]);
                }
            }

            let numAdditionalItems = (res.data.products.length > 3 ) ?
                '+' + (res.data.products.length - 3) + 'item(s)' : '';

            document.getElementById('product-cart-additional-items').innerText = numAdditionalItems;
        }
        else
        {
            let emptyCart = '<div class="row no-gutters align-items-center p-3">Your cart is empty</div><hr class="m-0">';
            document.getElementById('cart-dropdown-menu-products').insertAdjacentHTML('beforeend', emptyCart);
        }
    });
}

/**
 * Create product item in dropdown cart
 * @param product
 */
function createCartProductItem(product)
{
    let productUnit = (product.abbreviation !== null) ? product.abbreviation : '';
    let item ='<div class="row no-gutters align-items-center p-3">' +
        '<div class="col-2">' +
            '<img src="img/products/' + product.image + '" class="avatar img-fluid h-auto" alt="' + product.name + '">' +
        '</div>' +
        '<div class="col-10 pl-2">' +
            '<div class="text-dark first-letter-uppercase">' + product.name + '</div>' +
            '<div class="text-muted small mt-1"><span class="usd-money">' + product.price + '</span>✕' + product.quantity + ' ' + productUnit + '</div>' +
        '</div>' +
    '</div>' +
    '<hr class="m-0">';

    document.getElementById('cart-dropdown-menu-products').insertAdjacentHTML('beforeend', item);
}

/**
 * Validation quantity value
 * @param type 'unit type'
 * @param val
 * @returns {boolean}
 */
function validation(type, val)
{
    if((type * 1) === 2)
    {
        return /^([0-9]+\.[0-9]{1,2})|([0-9]+)$/.exec(val) !== null;
    }
    else
    {
        return /^([0-9]+)$/.exec(val) !== null;
    }
}

document.body.addEventListener("click", function(e)
    {
        let target = e.target;

        if(target.dataset.cartProduct === 'remove')
        {
            let cartProduct = target.closest('[data-product-card="box"]');

            let productId = cartProduct.dataset.product * 1;

            if(removeCartPositionCookie(productId) > 0)
            {
                cartProduct.remove();

                rewriteTotalCard();

                moneyFormat();
            }
            else
            {
                switchEmptyCart();
            }

            rewriteCart();
        }
    }
);

$('body').on('click', function(e)
{
    if(e.target.dataset.group === 'cart')
    {
        showModal('#cart-dropdown-menu');
    }

    if(e.target.dataset.group === 'user')
    {
        showModal('#account-dropdown-menu');
    }

    if(e.target.tagName === 'LABEL' && 'productRating' in e.target.parentElement.dataset)
    {
        let productId = e.target.parentElement.dataset.productRating;

        let starLabelId = e.target.getAttribute('for');

        let grade = document.getElementById(starLabelId).value;

        estimate(productId, grade);
    }

});

$('input').on('input', function(e)
{
    let target = e.target;

    if((target.dataset.productUnits === 'quantity' && !validation(target.dataset.unitType, target.value)) ||
        (target.value * 1) === 0)
    {
         target.value = target.dataset.lastValue;

        return;
    }
    else
    {
        target.dataset.lastValue = ((target.dataset.unitType * 1) === 2) ? Math.ceil((target.value)*100)/100 : target.value;

        let res = /^([0-9]+\.[0-9]{3,})$/.exec(target.value);

        if(res !== null) target.value =  Math.ceil((target.value)*100)/100;
    }

    if(target.dataset.cart === 'active')
    {
        let productCardBox = target.closest('[data-product-card="box"]');

        let productPrice = productCardBox.querySelector('[data-product="price"]').dataset.price * 1;

        let productId = productCardBox.dataset.product;

        let productQuantity = target.value;

        let productTotalAmountBox = productCardBox.querySelector('[data-product="sum"]');

        let productTotalAmount = productQuantity * productPrice;

        productTotalAmountBox.innerText = productTotalAmount;

        productTotalAmountBox.dataset.productSum = productTotalAmount;

        rewriteTotalCard();

        updateCart(productId, productQuantity);

        moneyFormat();

    }
});

$('input').on('change', function(e)
{
    let target = e.target;

    if(target.dataset.cart === 'active')
    {
        rewriteCart();
    }
});

$(document).ready(function()
    {
        moneyFormat();

        rewriteCart();
    }
);
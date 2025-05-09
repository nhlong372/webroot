
function updateCart(id = 0, code = "", quantity = 1) {
    if (id) {
        var formCart = $(".form-cart");
        var ward = formCart.find(".select-ward-cart").val();
        $.ajax({
            type: "POST",
            url: "api/cart.php",
            dataType: "json",
            data: {
                cmd: "update-cart",
                id: id,
                code: code,
                quantity: quantity,
                ward: ward,
            },
            beforeSend: function () {
                HoldOn.open({
                    theme:"sk-bounce",
                    message:'Vui lòng chờ tí ...'
                });
            },
            success: function (result) {
                if (result) {
                    formCart
                        .find(".load-price-" + code)
                        .html(result.regularPrice);
                    formCart
                        .find(".load-price-new-" + code)
                        .html(result.salePrice);
                    formCart.find(".load-price-temp").html(result.tempText);
                    formCart.find(".load-price-total").html(result.totalText);
                }
                holdonClose();
            },
        });
    }
}
function deleteCart(obj) {
    var formCart = $(".form-cart");
    var code = obj.data("code");
    var ward = formCart.find(".select-ward-cart").val();
    $.ajax({
        type: "POST",
        url: "api/cart.php",
        dataType: "json",
        data: {
            cmd: "delete-cart",
            code: code,
            ward: ward,
        },
        beforeSend: function () {
            HoldOn.open({
                theme:"sk-bounce",
                message:'Vui lòng chờ tí ...'
            });
        },
        success: function (result) {
            $(".count-cart").html(result.max);
            if (result.max) {
                formCart.find(".load-price-temp").html(result.tempText);
                formCart.find(".load-price-total").html(result.totalText);
                formCart.find(".procart-" + code).remove();
            } else {
                $(".wrap-cart").html(
                    '<a href="" class="empty-cart text-decoration-none"><img src="assets/images/cart-empty.svg" alt="Empty Cart"><p>' +
                        LANG["no_products_in_cart"] +
                        '</p><span class="btn btn-warning">' +
                        LANG["back_to_home"] +
                        "</span></a>"
                );
            }
            holdonClose();
        },
    });
}
function loadDistrict(id = 0) {
    $.ajax({
        type: "post",
        url: "api/district.php",
        data: {
            id_city: id,
        },
        beforeSend: function () {
            HoldOn.open({
                theme:"sk-bounce",
                message:'Vui lòng chờ tí ...'
            });
        },
        success: function (result) {
            $(".select-district").html(result);
            $(".select-ward").html(
                '<option value="">' + LANG["ward"] + "</option>"
            );
            holdonClose();
        },
    });
}
function loadWard(id = 0) {
    $.ajax({
        type: "post",
        url: "api/ward.php",
        data: {
            id_district: id,
        },
        beforeSend: function () {
            HoldOn.open({
                theme:"sk-bounce",
                message:'Vui lòng chờ tí ...'
            });
        },
        success: function (result) {
            $(".select-ward").html(result);
            holdonClose();
        },
    });
}
function loadShip(id = 0) {
    if (SHIP_CART) {
        var formCart = $(".form-cart");
        $.ajax({
            type: "POST",
            url: "api/cart.php",
            dataType: "json",
            data: {
                cmd: "ship-cart",
                id: id,
            },
            beforeSend: function () {
                HoldOn.open({
                    theme:"sk-bounce",
                    message:'Vui lòng chờ tí ...'
                });
            },
            success: function (result) {
                if (result) {
                    formCart.find(".load-price-ship").html(result.shipText);
                    formCart.find(".load-price-total").html(result.totalText);
                }
                holdonClose();
            },
        });
    }
}
function fill_price(price = 0) {
    $('.price-new-pro-detail').html(price + 'đ');
    $('.price-old-pro-detail').html('');
    return false;
}
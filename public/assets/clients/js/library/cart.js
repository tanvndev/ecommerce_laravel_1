if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.sendAjaxAddCart = (option) => {
        $.ajax({
            type: "POST",
            url: "/ajax/cart/create",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: option,
            dataType: "json",
            beforeSend: function () {
                $(".add-to-cart .btn").addClass("disabled");
            },
            success: function (response) {
                if (!response || response.code != 200) {
                    setToast("error", "Có lỗi xảy ra, vui lòng thử lại");
                    return false;
                }
                setToast("success", response.message);
                init.handleUpdateCart(response.data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            },
            complete: function () {
                // Thực hiện các hành động sau khi ajax hoàn thành (thành công hoặc thất bại)
                setTimeout(function () {
                    $(".add-to-cart .btn").removeClass("disabled");
                }, 1800);
            },
        });
    };
    init.addCart = () => {
        $(document).on("click", ".add-to-cart-btn", function (e) {
            let _this = $(this);
            let productId = _this.data("id");
            let quantity = $(".product-action-wrapper .pro-qty input").val();
            if (!quantity || quantity == undefined) {
                quantity = 1;
            }

            // Kiem tra da chon bien the chua
            if (init.checkChooseVariant()) {
                return false;
            }

            let attributeId = [];
            $(".range-variant .choose-attribute.active").each(function () {
                attributeId.push($(this).data("attribute-id"));
            });

            let option = {
                productId,
                quantity,
                attributeId,
            };
            init.sendAjaxAddCart(option);
        });
    };

    init.checkChooseVariant = () => {
        const allVariantsSelected = $(".product-variation")
            .toArray()
            .every(function (variant) {
                return $(variant).find(".choose-attribute.active").length === 1;
            });

        if (!allVariantsSelected) {
            $(".range-variant .choose-attribute").addClass("invalid");
            return true;
        }

        return false;
    };

    init.sendAjaxChangeQuantity = (option) => {
        $.ajax({
            type: "PUT",
            url: "/ajax/cart/update",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: option,
            dataType: "json",

            success: function (response) {
                if (!response || response.code != 200) {
                    setToast("error", "Có lỗi xảy ra, vui lòng thử lại");
                    return false;
                }
                $(".cart-subtotal .subtotal-amount").text(
                    formatCurrency(response.data?.total || 0)
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            },
            complete: function () {
                // Thực hiện các hành động sau khi ajax hoàn thành (thành công hoặc thất bại)
            },
        });
    };

    init.changeQuantity = () => {
        let typingTimeout;

        const handleQuantityChange = (input) => {
            let qty = parseInt(input.val());

            if (isNaN(qty) || qty < 1) {
                setToast("error", "Có lỗi xảy ra, vui lòng thử lại");
                return false;
            }

            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                let option = {
                    qty,
                    rowId: input.closest(".cart-item").data("rowid"),
                };
                init.sendAjaxChangeQuantity(option);
            }, 1000);
        };

        // Xử lý sự kiện click trên nút tăng/giảm số lượng
        $(document).on("click", ".cart-item .qtybtn", function () {
            let qtyInput = $(this).siblings(".quantity-input");
            let qty = parseInt(qtyInput.val());

            qty = $(this).hasClass("inc") ? qty + 1 : Math.max(qty - 1, 1);

            qtyInput.val(qty);
            handleQuantityChange(qtyInput);
        });

        // Xử lý sự kiện input trên input số lượng
        $(document).on("input", ".item-quantity .quantity-input", function () {
            handleQuantityChange($(this));
        });
    };

    init.sendAjaxDeleteCartItem = (option) => {
        $.ajax({
            type: "DELETE",
            url: "/ajax/cart/destroy",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: option,
            dataType: "json",

            success: function (response) {
                if (!response || response.code != 200) {
                    setToast("error", "Có lỗi xảy ra, vui lòng thử lại");
                    return false;
                }
                init.handleUpdateCart(response.data);
                return true;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            },
            complete: function () {
                // Thực hiện các hành động sau khi ajax hoàn thành (thành công hoặc thất bại)
            },
        });
    };
    init.deleteCartItem = () => {
        $(document).on("click", ".cart-item .delete-cart-item", function () {
            const _this = $(this);
            let cartItem = _this.closest(".cart-item");
            let option = {
                rowId: cartItem.data("rowid"),
            };

            setTimeout(() => {
                init.sendAjaxDeleteCartItem(option);
            }, 300);
        });
    };

    init.cartItemHtml = (cart) => {
        // console.log(cart);
        const { rowId, name, price, qty } = cart;
        const { image, code, originalPrice, canonical } = cart.options[0];

        const url = code
            ? `${BASE_URL}/${canonical}?attribute_id=${code}`
            : `${BASE_URL}/${canonical}`;

        const formattedPrice = formatCurrency(price);
        const formattedOriginalPrice = formatCurrency(originalPrice);

        return `
            <li class="cart-item" data-rowid="${rowId}">
                <div class="item-img">
                    <a href="${url}" title="${name}">
                        <img src="${image}" alt="${name}">
                    </a>
                    <button type="button" class="close-btn delete-cart-item"><i class="fas fa-times"></i></button>
                </div>
                <div class="item-content">
                    <h3 class="item-title">
                        <a href="${url}" title="${name}">${name}</a>
                    </h3>
                    <div class="item-price">
                        <span class="price">${formattedPrice}</span>
                        ${
                            price != originalPrice
                                ? `<del>${formattedOriginalPrice}</del>`
                                : ""
                        }
                    </div>
                    <div class="pro-qty item-quantity">
                        <span class="dec qtybtn">-</span>
                            <input type="text" class="quantity-input only-number" value="${qty}">
                        <span class="inc qtybtn">+</span>
                    </div>
                </div>
            </li>
        `;
    };

    init.handleUpdateCart = (data) => {
        let html = `
        <li class="text-center">
            <img src="/public/userfiles/image/other/icon-empty-cart.png" alt="not-cart">
            <p>Chưa có sản phẩm nào.</p>
        </li>
        `;
        if (data.count > 0) {
            html = Object.values(data.carts)
                .map((cart) => {
                    return init.cartItemHtml(cart);
                })
                .join("");
        }

        $(".cart-item-list").html(html);
        $(".cart-subtotal .subtotal-amount").text(
            formatCurrency(data.total || 0)
        );
        $(".shopping-cart .cart-count").text(data.count || 0);
    };

    init.getCart = () => {
        $.ajax({
            type: "GET",
            url: "/ajax/cart/getCart",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (response) {
                if (!response || response.code != 200) {
                    setToast("error", "Có lỗi xảy ra, vui lòng thử lại");
                    return false;
                }
                init.handleUpdateCart(response.data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            },
        });
    };

    init.changeTransportMethod = () => {
        $(document).on("change", ".transport-method", function () {
            const transportMethodValue = parseFloat($(this).val());
            const shippingAmountElement = $(".shipping-amount .amount");
            const totalElement = $(".order-total .order-total-amount");
            // Cập nhật giá trị phí vận chuyển
            shippingAmountElement.text(formatCurrency(transportMethodValue));

            const currentTotal = parseFloat(totalElement.data("total"));
            const newTotal = currentTotal - transportMethodValue;

            totalElement.text(formatCurrency(newTotal));
        });
    };

    $(document).ready(function () {
        init.addCart();
        init.changeQuantity();
        init.deleteCartItem();
        init.getCart();
        init.changeTransportMethod();
    });
});

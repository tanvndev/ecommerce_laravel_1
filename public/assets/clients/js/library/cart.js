if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.addCart = () => {
        $(document).on("click", ".add-to-cart-btn", function (e) {
            let _this = $(this);
            let productId = _this.data("id");
            let quantity = $("pro-qty input").val();
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
            console.log(option);

            $.ajax({
                type: "POST",
                url: "/ajax/cart/create",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: option,
                dataType: "json",
                beforeSend: function () {
                    $(".add-to-cart .btn").addClass("disabled");
                },
                success: function (response) {
                    if (!response) {
                        return false;
                    }
                    console.log(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                    // Xử lý lỗi nếu có
                },
                complete: function () {
                    // Thực hiện các hành động sau khi ajax hoàn thành (thành công hoặc thất bại)
                    $(".add-to-cart .btn").removeClass("disabled");
                },
            });
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

    $(document).ready(function () {
        init.addCart();
    });
});

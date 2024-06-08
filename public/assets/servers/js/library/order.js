if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.sendAjaxUpdateOrder = (payload, field, _this) => {
        $.ajax({
            type: "PUT",
            url: `/ajax/order/${payload.id}/update`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: payload,
            success: function (response) {
                setToast(response.type, response.message);
                if (field == "confirm" && payload.confirm == "cancel") {
                    _this
                        .closest(".order-item-tr")
                        .find(".update-order-wrap")
                        .html(
                            '<span class="badge text-center bg-danger">Đơn hàng đã hủy</span>'
                        );
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                setToast("error", "Có lỗi vui lòng thử lại.");
            },
        });
    };
    init.updateOrder = () => {
        $(document).on("change", ".update-order", function () {
            const _this = $(this);
            const field = _this.data("field");
            const confirmValue = _this
                .closest(".order-item-tr")
                .find('select[name="confirm"]')
                .val();
            const value = _this.val();
            const id = _this.parents(".order-item-tr").data("order-id");
            const payload = {
                id,
                [field]: value,
            };
            if (confirmValue == "pending") {
                return setToast(
                    "warning",
                    "Vui lòng xác nhận đơn hàng trước khi thay đổi."
                );
            }
            setTimeout(() => {
                return init.sendAjaxUpdateOrder(payload, field, _this);
            }, 500);
        });
    };

    $(document).ready(function () {
        init.updateOrder();
    });
});

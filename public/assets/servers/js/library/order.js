if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.formInfoOrderHtml = () => {};
    init.updateInfoOrder = () => {
        $(document).on("click", ".update-info-order", function () {
            // const order = JSON.parse($('input[name="orderDetail"]').val());
            // console.log(order);
        });
    };

    $(document).ready(function () {
        init.updateInfoOrder();
    });
});

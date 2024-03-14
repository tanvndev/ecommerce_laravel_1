if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function () {
    "use strict";
    var init = {};

    init.seoPreview = () => {
        if ($("input[name=meta_title]").length > 0) {
            $("input[name=meta_title]").on("keyup", function () {
                const _this = $(this);
                const value = _this.val();
                $(".meta-title").html(value);
            });
        }

        if ($("input[name=canonical]").length > 0) {
            $("input[name=canonical]").on("keyup", function () {
                const _this = $(this);
                const value = _this.val();
                $(".meta-url").html(BASE_URL + "/" + value);
            });
        }
        if ($("textarea[name=meta_description]").length > 0) {
            $("textarea[name=meta_description]").on("keyup", function () {
                const _this = $(this);
                const value = _this.val();
                $(".meta-description").html(value);
            });
        }
    };

    $(document).ready(function () {
        init.seoPreview();
    });
});

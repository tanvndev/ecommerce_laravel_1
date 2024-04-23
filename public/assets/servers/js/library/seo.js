if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.seoPreview = () => {
        function updatePreview(selector, value) {
            $(selector).html(value);
        }

        function handleInputChange(inputName, previewSelector, isSlug = false) {
            const inputField = $(
                `input[name=${inputName}], textarea[name=${inputName}]`
            );
            if (inputField.length > 0) {
                inputField.on("keyup", function () {
                    const _this = $(this);
                    let value = _this.val();
                    if (isSlug) {
                        value = convertToSlug(value);
                        value = BASE_URL + "/" + value;
                    }
                    updatePreview(previewSelector, value);
                });
            }
        }

        handleInputChange("meta_title", ".meta-title");
        handleInputChange("canonical", ".meta-url", true);
        handleInputChange("meta_description", ".meta-description");
        handleInputChange("translate_meta_title", ".translate-meta-title");
        handleInputChange("translate_canonical", ".translate-meta-url", true);
        handleInputChange(
            "translate_meta_description",
            ".translate-meta-description"
        );
    };

    $(document).ready(function () {
        init.seoPreview();
    });
});

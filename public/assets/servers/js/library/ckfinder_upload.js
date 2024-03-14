if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function () {
    "use strict";
    var init = {};

    init.uploadImageToInput = () => {
        $(".upload-image").click(function () {
            const input = $(this);
            const type = $(this).data("type");
            init.setUpCkFinder(input, type);
        });
    };

    init.setUpCkFinder = (object, type) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data) {
            if (!fileUrl) {
                return setToast("warning", "Có lỗi liên quan tới upload.");
            }
            object.val(fileUrl);
        };
        finder.popup();
    };
    $(document).ready(function () {
        init.uploadImageToInput();
    });
});

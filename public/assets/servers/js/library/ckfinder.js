if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function () {
    "use strict";
    var init = {};

    init.setUpCkEditer = () => {
        if ($(".init-ckeditor").length > 0) {
            $(".init-ckeditor").each((index, element) => {
                let elementId = $(element).attr("id");
                let elementHeight = $(element).data("height");
                init.ckeditor4(elementId, elementHeight);
            });
        }
    };

    init.ckeditor4 = (elementId, elementHeight) => {
        if (typeof elementHeight == "undefined") {
            elementHeight = 500;
        }
        CKEDITOR.replace(elementId, {
            height: elementHeight,
            removeButtons: "",
            entities: true,
            allowedContent: true,
            toolbarGroups: [
                {
                    name: "editing",
                    groups: ["find", "selection", "spellchecker", "undo"],
                },
                { name: "links" },
                { name: "insert" },
                { name: "forms" },
                { name: "tools" },
                { name: "document", groups: ["mode", "document", "doctools"] },
                { name: "others" },
                {
                    name: "basicstyles",
                    groups: [
                        "basicstyles",
                        "cleanup",
                        "colors",
                        "styles",
                        "indent",
                    ],
                },
                {
                    name: "paragraph",
                    groups: ["list", "", "blocks", "align", "bidi"],
                },
            ],
            removeButtons:
                "Save,NewPage,Pdf,Preview,Print,Find,Replace,CreateDiv,SelectAll,Symbol,Block,Button,Language",
            removePlugins: "exportpdf",
        });
    };

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
        init.setUpCkEditer();
    });
});

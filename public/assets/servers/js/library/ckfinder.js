if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function () {
    "use strict";
    var init = {};

    init.uploadImageAvatar = () => {
        if ($(".img-target").length > 0) {
            $(".img-target").click(function () {
                const input = $(this);
                const type = "Images";
                init.browseServerAvatar(input, type);
            });
        }
    };

    init.uploadAlbum = () => {
        if ($(".upload-picture").length > 0) {
            $(".upload-picture").click(function (e) {
                e.preventDefault();
                const type = "Images";

                init.browseServerAlbum(type);
            });
        }
    }

    init.mutipleUploadImageCkEditor = () => {
        if ($(".mutipleUploadImageCkEditor").length > 0) {
            $(".mutipleUploadImageCkEditor").click(function (e) {
                e.preventDefault();
                const object = $(this);
                const target = object.data("target");
                const type = "Images";
                init.browseServerCkEditor(object, type, target);
            });
        }
    };

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

    init.browseServerAvatar = (object, type) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data) {
            if (!fileUrl) {
                return setToast("warning", "Có lỗi liên quan tới upload.");
            }
            object.attr("src", fileUrl);
            object.siblings("input").val(fileUrl);
        };
        finder.popup();
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

    init.browseServerCkEditor = (object, type, target) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data, allFiles) {
            if (allFiles.length <= 0) {
                return setToast("warning", "Có lỗi liên quan tới upload.");
            }
            let html = "";
            for (var i = 0; i < allFiles.length; i++) {
                var image = allFiles[i].url;
                html += '<div class="image-content"><figure>';
                html += '<img src="' + image + '" alt="' + image + '">';
                html += "<figcaption>Nhập vào mô tả cho ảnh</figcaption>";
                html += "</figure></div>";
            }
            CKEDITOR.instances[target].insertHtml(html);
        };
        finder.popup();
    };

    init.browseServerAlbum = (type) => {
         if (typeof type == "undefined") {
            type = "Images";
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data, allFiles) {
            if (allFiles.length <= 0) {
                return setToast("warning", "Có lỗi liên quan tới upload.");
            }
            let html = "";
            for (var i = 0; i < allFiles.length; i++) {
                var image = allFiles[i].url;
                html += `
                <div class="col-lg-2 album-item">
                    <div class="position-relative ">
                        <img class="img-thumbnail image-album"
                            src="${image}" alt="${image}">
                        <span class="position-absolute icon-delete-album">
                            <i class=" icofont-ui-delete"></i>
                        </span>
                        <input type="hidden" name="album[]" value="${image}">
                    </div>
                </div>
                `
            }
            $('.click-to-upload-area').addClass('d-none');
            $('.upload-image-list').removeClass('d-none');
            $('.upload-image-list').append(html);
        };
        finder.popup();
    }
    init.deletePictureAlbum = () => {
        $(document).on('click', '.icon-delete-album', function () {
            $(this).parent().parent().remove();

            if ($('.album-item').length <= 0) {
                $('.click-to-upload-area').removeClass('d-none');
                $('.upload-image-list').addClass('d-none');    
            }
           
        })
      
    }

    $(document).ready(function () {
        init.uploadImageToInput();
        init.setUpCkEditer();
        init.uploadImageAvatar();
        init.mutipleUploadImageCkEditor();
        init.uploadAlbum()
        init.deletePictureAlbum()
    });
});

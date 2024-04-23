if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};
    // Hàm button thêm slide
    init.addSlide = () => {
        $(".add-slide").on("click", function () {
            let type = "Images";
            let finder = new CKFinder();
            finder.resourceType = type;
            finder.selectActionFunction = function (fileUrl, data, allFiles) {
                if (!fileUrl || allFiles.length <= 0) {
                    return setToast("warning", "Có lỗi liên quan tới upload.");
                }
                allFiles.forEach((item) => {
                    $(".slide-list").append(init.renderSlideItemHtml(item.url));
                });
                init.checkSlideEmpty();
            };
            finder.popup();
        });
    };

    // Hàm check slide empty
    init.checkSlideEmpty = () => {
        if ($(".slide-item").length > 0) {
            $(".list-slide-empty").hide();
        } else {
            $(".list-slide-empty").show();
        }
    };

    // Hàm delete Slide Item slide
    init.deleteSlideItem = () => {
        $(document).on("click", ".delete-slide-item", function () {
            $(this).parents(".slide-item").remove();
            init.checkSlideEmpty();
        });
    };

    // Hàm render slide
    let counterSlide = $(".slide-item").length;
    init.renderSlideItemHtml = (image) => {
        let tab_1 = "nav-generalInfomation-" + counterSlide;
        let tab_2 = "nav-seo-" + (counterSlide + 1);

        let html = /*html*/ `
        <div class="row g-3 slide-item">
                <div class="col-lg-3 cursor-move">
                    <img class="img-thumbnail img-fluid"
                        src="${image}" alt="${image}">
                    <input type="hidden" name="slide[image][]" value="${image}">
                </div>
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center">
                        <ul class="nav nav-tabs tab-card w-100" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link pt-0 active" data-bs-toggle="tab" href="#${tab_1}"
                                    role="tab">Thông tin chung</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pt-0" data-bs-toggle="tab" href="#${tab_2}" role="tab">SEO</a>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-outline-danger fs-12 delete-slide-item mb-1 "><i
                                class="icofont-ui-delete"></i></button>
                    </div>

                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="${tab_1}" role="tabpanel">
                            <div class="row g-3 align-items-center ">
                                <div class="col-lg-12">
                                    <label class="form-label">Mô tả</label>
                                    <textarea class="form-control textarea-expand" name="slide[description][]" cols="30"
                                        rows="2"></textarea>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" name="slide[canonical][]" class="form-control" placeholder="URL">
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="slide[window][]"
                                            value="_blank" id="slide[window][${counterSlide}]" />
                                        <label class="form-check-label" for="slide[window][${counterSlide}]"> Mở trong tab mới </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="${tab_2}" role="tabpanel">
                            <div class="row g-3 align-items-center ">
                                <div class="col-lg-12">
                                    <label class="form-label">Tiêu đề SEO</label>
                                    <input class="form-control" name="slide[name][]" type="text">
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label">Mô tả SEO</label>
                                    <textarea class="form-control textarea-expand" name="slide[alt][]" cols="30"
                                        rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        counterSlide += 2;
        return html;
    };

    // Hàm send ajax drag slide
    init.sendAjaxDragSlide = (image, id) => {
        $.ajax({
            url: "/ajax/slide/drag",
            method: "PUT",
            data: {
                _token: $("meta[name='csrf-token']").attr("content"),
                id,
                image,
            },
            type: "json",
            success: function (response) {
                setToast(response.type, response.message);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            },
        });
    };

    // Hàm drag slide
    init.dragSlideImage = () => {
        if ($("#sortable-slide").length <= 0) {
            return;
        }
        $("#sortable-slide").sortable({
            // Thực hiện khi sắp xếp xong
            stop: function (event, ui) {
                let image = [];
                const id = $("#sortable-slide").data("id");
                $(".sortable-item").each(function () {
                    image.push($(this).find("input[name='image[]']").val());
                });
                init.sendAjaxDragSlide(image, id);
            },
        });
        $("#sortable-slide").disableSelection();
    };
    $(document).ready(function () {
        init.addSlide();
        init.deleteSlideItem();
        init.dragSlideImage();
    });
});

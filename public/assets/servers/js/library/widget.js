if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};
    var _token = $('meta[name="csrf-token"]').attr("content");

    // Hàm này gửi ajax để lấy ra widget model
    init.sendAjaxGetModel = async (option) => {
        try {
            $(".search-widget-result").show().html(`
                <div class="loader-menu-model w-100 "></div>
            `);

            const response = await $.ajax({
                type: "GET",
                url: "/ajax/dashboard/findModelObject",
                data: option,
                dataType: "json",
            });

            const html = init.renderSearchResultHtml(response);
            const resultContainer = $(".search-widget-result");

            if (html) {
                resultContainer.html(html);
                init.checkChooseModel();
            } else {
                resultContainer.html(`
                    <div class="search-widget-item disabled">
                        <span class="search-widget-title">
                            Không tìm thấy kết quả.
                        </span>
                    </div>
                `);
            }
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm này search ra model
    init.searchModel = () => {
        let typingTimeout;
        $(document).on("keyup", ".input-widget-search", function () {
            let _this = $(this);
            let model = _this
                .parents(".widget-search-wrap")
                .find("select[name='model']")
                .val();
            let option = {
                _token,
                model,
                keyword: _this.val(),
            };

            clearTimeout(typingTimeout);

            typingTimeout = setTimeout(function () {
                if (!model || model == 0) {
                    _this.val("");
                    return setToast("warning", "Vui lòng lựa chọn module.");
                }
                init.sendAjaxGetModel(option);
            }, 500);
        });
    };

    // Hàm này khi chọn model sẽ gửi ajax
    init.chooseModel = () => {
        $(document).on("change", "select[name='model']", function () {
            $(".search-model-result").empty();
            let _this = $(this);
            let model = _this.val();
            if (!model || model == 0) {
                $(".search-widget-result").hide();
                return setToast("warning", "Vui lòng lựa chọn module.");
            }
            let option = {
                _token,
                model,
                keyword: $(".input-widget-search").val(),
            };
            init.sendAjaxGetModel(option);
        });
    };

    // Hàm này là hàm render search result html
    init.renderSearchResultHtml = (data) => {
        return (
            data.length &&
            data
                ?.map((item) => {
                    if (item.languages.length > 0) {
                        let name = item?.languages[0]?.pivot?.name;
                        let canonical = item?.languages[0]?.pivot?.canonical;

                        return /*html*/ `
                            <div class="search-widget-item" 
                                data-id="${item.id}" 
                                data-title="${name}" 
                                data-image="${item.image}" 
                                data-canonical="${canonical}"
                                >
                                <span class="search-widget-title">
                                    ${name}
                                </span>
                                <i class="icofont-check icon-widget-check"></i>
                            </div>
                        `;
                    } else {
                        return "";
                    }
                })
                .join("")
        );
    };

    // Hàm này khi nhấn ra ra khoảng trông sẽ đóng box search
    init.closeSearchWidget = () => {
        function closeSearchWidgetHandler(e) {
            if (
                !$(e.target).hasClass("input-widget-search") &&
                !$(e.target).hasClass("search-widget-result")
            ) {
                $(".input-widget-search").val("");
                $(".search-widget-result").hide();
            }
        }
        // Gỡ bỏ bất kỳ sự kiện click trên body nào đã được gắn trước đó
        $(document).off("click", "body", closeSearchWidgetHandler);
        // Gắn kết sự kiện click mới trên body
        $(document).on("click", "body", closeSearchWidgetHandler);
        // Gắn kết sự kiện click trên .search-widget-item và ngăn chặn lan truyền
        $(document).on("click", ".search-widget-item", function (e) {
            e.stopPropagation();
        });
    };

    // Hàm này add model
    init.createModel = () => {
        $(document).on("click", ".search-widget-item", function () {
            const _this = $(this);
            _this.toggleClass("active");
            if (_this.hasClass("active")) {
                $(".search-model-result").append(
                    init.renderModelHtml(_this.data())
                );
            } else {
                $(".search-model-result")
                    .find(`[data-modelid="${_this.data().id}"]`)
                    .remove();
            }
        });
    };

    // Ham nay render html model
    init.renderModelHtml = (data) => {
        let html = /*html*/ `
            <div class="border-bottom search-model-item" data-modelid="${data.id}">
                <div>
                    <img src="${data.image}"
                        alt="${data.title}">
                    <span>${data.title}</span>
                    
                    <input type="hidden" name="modelItem[id][]" value="${data.id}">
                    <input type="hidden" name="modelItem[name][]" value="${data.title}">
                    <input type="hidden" name="modelItem[image][]" value="${data.image}">
                    <input type="hidden" name="modelItem[canonical][]" value="${data.canonical}">
                </div>
                <button type="button" class="btn-close delete-model-item" aria-label="Close"></button>
            </div>
        `;
        return html;
    };

    // Kiểm model đã chưa khi đã có trong list
    init.checkChooseModel = () => {
        if ($(".search-model-item").length > 0) {
            $("input[name='modelItem[canonical][]']").each(function () {
                $(`[data-canonical="${$(this).val()}"]`).addClass("active");
            });
        }
    };

    //Ham nay giup xoa model
    init.deleteModelItem = () => {
        $(document).on("click", ".delete-model-item", function () {
            $(this).parents(".search-model-item").remove();
        });
    };

    $(document).ready(function () {
        init.searchModel();
        init.chooseModel();
        init.closeSearchWidget();
        init.createModel();
        init.deleteModelItem();
    });
});

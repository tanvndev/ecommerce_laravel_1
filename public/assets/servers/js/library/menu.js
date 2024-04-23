if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};
    var _token = $('meta[name="csrf-token"]').attr("content");

    // Hàm này tạo ra các menu catalogue
    init.createMenuCatalogue = () => {
        $(document).on("submit", ".create-menu-catalogue", function (e) {
            e.preventDefault();
            const _this = $(this);
            // Lấy ra các giá trị của form
            const _data = _this.serialize();

            $.ajax({
                type: "POST",
                url: "/ajax/menu/createCatalogue",
                data: _data,
                dataType: "json",
                beforeSend: function () {
                    _this.find('button[type="submit"]').prop("disabled", true);
                    _this.find("input[name]").removeClass("is-invalid");
                },
                success: function (response) {
                    if (response && response.data) {
                        $(".menu-catalogue-id").append(
                            `<option value="${response.data?.id}">${response.data?.name}</option>`
                        );
                        return setToast(response.type, response.message);
                    }
                    setToast("error", "Có lỗi vui lòng thử lại.");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        const errors = jqXHR.responseJSON.errors;
                        for (const field in errors) {
                            if (Object.hasOwnProperty.call(errors, field)) {
                                const errorMessage = errors[field];
                                _this
                                    .find(`input[name=${field}]`)
                                    .addClass("is-invalid")
                                    .next(".invalid-feedback")
                                    .text(errorMessage[0]);
                            }
                        }
                    }
                },
                complete: function () {
                    _this.find('button[type="submit"]').prop("disabled", false);
                    _this[0].reset();
                },
            });
        });
    };

    // Hàm này tạo ra các row menu
    init.createMenuRow = () => {
        $(document).on("click", ".create-menu-row", function () {
            let _this = $(this);
            $(".menu-row-wrap")
                .append(init.menuRowHtml())
                .find(".menu-row-empty")
                .hide();
        });
    };

    // Hàm này trả về html row menu
    init.menuRowHtml = (data) => {
        let html = /*html*/ `    
        <tr class="menu-row-item ${data?.canonical ?? ""}">
            <td>
                <input type="text" class="form-control" ${
                    data?.name ? "readonly" : ""
                } name="menu[name][]" value="${data?.name ?? ""}"/>
            </td>
            <td>
                <input type="text" class="form-control" ${
                    data?.canonical ? "readonly" : ""
                } name="menu[canonical][]" value="${data?.canonical ?? ""}"/>
            </td>
            <td>
                <input type="number" class="form-control text-end" name="menu[order][]" value="0"/>
                <input type="hidden" value="0" name="menu[id][]">
            </td>
            <td class="text-center ">
                <button type="button"
                    class="btn btn-outline-secondary text-danger px-2 delete-menu-row">
                    <i class="icofont-trash fs-14 "></i>
                </button>
            </td>
        </tr>
        `;
        return html;
    };

    // Hàm này xoá row menu
    init.deleteMenuRow = () => {
        $(document).on("click", ".delete-menu-row", function () {
            let _this = $(this);
            let canonical = _this
                .parents(".menu-row-item")
                .find('input[name="menu[canonical][]"]')
                .val();

            $(`[value="${canonical}"]`).prop("checked", false);

            _this.parents(".menu-row-item").remove();
            init.checkMenuRowItem();
        });
    };

    // Hàm này giúp checkrow item để ẩn hay hiển thị thông báo trống
    init.checkMenuRowItem = () => {
        if ($(".menu-row-item").length <= 0) {
            $(".menu-row-empty").show();
        }
    };

    // Kiểm trang checked khi đã có trong list
    init.checkChooseMenu = () => {
        if ($('input[name="menu[canonical][]"]').length > 0) {
            $('input[name="menu[canonical][]"]').each(function () {
                $(`[value="${$(this).val()}"]`).prop("checked", true);
            });
        }
    };

    // Hàm này gửi ajax để lấy ra menu model
    init.sendAjaxGetMenu = (option, _this) => {
        $.ajax({
            type: "GET",
            url: "/ajax/dashboard/getMenu",
            data: option,
            dataType: "json",
            beforeSend: function () {
                $(".menu-list-inner").html(`
                    <div class="loader-menu-model w-100 "></div>
                `);
            },
            success: function (response) {
                let html = "";
                response?.data?.forEach((item) => {
                    html += init.renderModelMenu(item);
                });
                if (response.last_page > 1) {
                    html += init.renderMenuPagination(response?.links);
                }
                setTimeout(() => {
                    _this
                        .parents(".menu-list-wrap")
                        .find(".menu-list-inner")
                        .html(html);
                    init.checkChooseMenu();
                }, 500);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
        });
    };

    // Hàm này giúp hiển thị search menu
    init.getMenu = () => {
        $(document).on("click", ".menu-module", function () {
            let _this = $(this);
            let option = {
                _token,
                model: _this.data("model"),
            };

            init.sendAjaxGetMenu(option, _this);
        });
    };
    // Hàm này get ra pagination menu
    init.getPaginationMenu = () => {
        $(document).on(
            "click",
            ".pagination-menu-model .page-link",
            function (event) {
                event.preventDefault();
                let _this = $(this);

                const href = _this.attr("href");
                const urlParams = new URLSearchParams(href);

                let _thisMenuModule = _this
                    .parents(".menu-list-wrap")
                    .find(`.button-menu-${urlParams.get("model")}`);

                let option = {
                    _token,
                    model: urlParams.get("model"),
                    page: urlParams.get("page"),
                    keyword: urlParams.get("keyword"),
                };

                init.sendAjaxGetMenu(option, _thisMenuModule);
            }
        );
    };

    // Render html menu model
    init.renderModelMenu = (data) => {
        let html = /*html*/ `
            <div class="form-check">
                <input class="form-check-input choose-menu" type="checkbox" value="${data.canonical}" id="${data.canonical}" />
                <label class="form-check-label" for="${data.canonical}"> ${data.name} </label>
            </div>
        `;
        return html;
    };
    // Hàm này giúp tìm ra check box menu model
    init.chooseMenu = () => {
        $(document).on("click", ".choose-menu", function () {
            let _this = $(this);
            if (_this.is(":checked")) {
                let menuRow = init.menuRowHtml({
                    name: _this.siblings("label").text(),
                    canonical: _this.val(),
                });

                $(".menu-row-wrap")
                    .append(menuRow)
                    .find(".menu-row-empty")
                    .hide();
            } else {
                $(".menu-row-wrap").find(`.${_this.val()}`).remove();
                init.checkMenuRowItem();
            }
        });
    };

    // Hàm này giúp tạo menu pagination
    init.renderMenuPagination = (data = []) => {
        let html = '<nav><ul class="pagination pagination-menu-model">';

        for (let item of data) {
            let label = "";
            if (item.label == "pagination.previous") {
                label = '<span aria-hidden="true">&laquo;</span>';
            } else if (item.label == "pagination.next") {
                label = '<span aria-hidden="true">&raquo;</span>';
            } else {
                label = item.label;
            }

            html += `
                <li class="page-item ${item.url == null ? "disabled " : ""} ${
                item.active ? "active" : ""
            }">
                    <a class="page-link" href="${item.url}">${label}</a>
                </li>
            `;
        }

        html += "</ul></nav>";

        return html;
    };

    // Hàm này dùng để tìm kiêm menu model
    init.seachMenu = () => {
        let typingTimeout;
        $(document).on("keyup", ".search-menu", function () {
            let _this = $(this);
            let keyword = _this.val();
            let model = _this.parents(".accordion-collapse").data("model");
            let _thisMenuModule = _this
                .parents(".menu-list-wrap")
                .find(`.button-menu-${model}`);

            let option = {
                _token,
                model,
                keyword,
            };

            clearTimeout(typingTimeout);

            typingTimeout = setTimeout(function () {
                init.sendAjaxGetMenu(option, _thisMenuModule);
            }, 500);
        });
    };

    // Khởi tạo nestedtable

    init.setUpNestedTable = () => {
        if ($("#nestable2").length > 0) {
            $("#nestable2")
                .nestable({
                    group: 1,
                })
                .on("change", init.updateNestedTableOutput);
        }
    };

    init.updateNestedTableOutput = (e) => {
        let list = $(e.currentTarget),
            output = $(list.data("output"));

        let json = window.JSON.stringify(list.nestable("serialize"));
        if (json.length) {
            let option = {
                _token,
                json,
                menu_catalogue_id: $("#menuCatalogueId").data("catalogue-id"),
            };
            $.ajax({
                type: "POST",
                url: "/ajax/menu/drag",
                data: option,
                dataType: "json",
                success: function (response) {
                    if (response) {
                        setToast(response.type, response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
            });
        }
    };

    init.expandAndCollapse = () => {
        $("#nestable-menu").on("click", function (e) {
            var target = $(e.target),
                action = target.data("action");
            if (action === "expand-all") {
                $(".dd").nestable("expandAll");
            }
            if (action === "collapse-all") {
                $(".dd").nestable("collapseAll");
            }
        });
    };

    $(document).ready(function () {
        init.createMenuCatalogue();
        init.createMenuRow();
        init.deleteMenuRow();
        init.getMenu();
        init.chooseMenu();
        init.getPaginationMenu();
        init.seachMenu();
        init.setUpNestedTable();
        init.expandAndCollapse();
    });
});

if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function () {
    "use strict";
    var init = {};
    var _token = $('meta[name="csrf-token"]').attr("content");

    // Hàm này xử lý khi nhấn chọn nút neverEnd
    init.promotionNeverEnd = () => {
        $(document).on("change", 'input[name="neverEnd"]', function () {
            const isChecked = $(this).prop("checked");
            $('input[name="end_date"]')
                .val(isChecked ? "" : $('input[name="start_date"]').val())
                .prop("disabled", isChecked);
        });
    };

    // Hàm này validate khi chọn ngày kết thúc nhỏ hơn ngày hiện tại
    init.validateEndDate = () => {
        $('input[name="end_date"]').on("input", function () {
            const _this = $(this);
            const endDate = _this.val();
            const startDate = $('input[name="start_date"]').val();
            const isInvalid = endDate && startDate && endDate < startDate;

            _this
                .toggleClass("is-invalid", isInvalid)
                .siblings(".invalid-feedback")
                .text(isInvalid ? "Ngày kết thúc phải sau ngày bắt đầu" : "");

            if (isInvalid) {
                _this.val(startDate);
            }
        });
    };

    // Hàm này giúp chọn source
    init.promotionSource = () => {
        $(document).on("change", 'input[name="source"]', function () {
            const _this = $(this);
            if (_this.val() == "choose") {
                let sourceHtml = init.renderPromotionSource();
                _this.parents(".source-inner").append(sourceHtml);
                init.promotionMutipleSelect2();
            } else {
                _this.parents(".source-inner").find(".source-wrapper").remove();
            }
        });
    };

    // Hàm này render ra source
    init.renderPromotionSource = () => {
        let sourceData = [
            {
                id: 1,
                name: "Tiktok",
            },
            {
                id: 2,
                name: "Youtube",
            },
        ];

        let html = /*html*/ `
            <div class="source-wrapper">
                <select name="" multiple class="form-select mutiple-select2">
                    ${
                        sourceData &&
                        sourceData
                            .map((item) => {
                                return /*html*/ `
                            <option value="${item.id}">${item.name}</option>
                        `;
                            })
                            .join("")
                    }
                </select>
            </div>
        `;
        return html;
    };

    // Hàm này giúp chọn apply condition
    init.promotionApplyCondition = () => {
        $(document).on("change", 'input[name="apply"]', function () {
            const _this = $(this);
            if (_this.val() == "choose") {
                let applyHtml = init.renderPromotionApplyCondition();
                _this.parents(".apply-condition-inner").append(applyHtml);
                init.promotionMutipleSelect2();
            } else {
                _this
                    .parents(".apply-condition-inner")
                    .find(".apply-condition-wrapper")
                    .remove();
            }
        });
    };

    //  Hàm này render ra apply condition
    init.renderPromotionApplyCondition = () => {
        let applyConditionData = [
            {
                id: "staff_take_care_customer",
                name: "Nhân viên chăm sóc khách hàng",
            },
            {
                id: "customer_group",
                name: "Nhóm khách hàng",
            },
            {
                id: "customer_gender",
                name: "Giới tính",
            },
            {
                id: "customer_birthday",
                name: "Ngày sinh",
            },
        ];

        let html = /*html*/ `
            <div class="apply-condition-wrapper">
                <div class="mb-4">
                    <select name="" multiple class="form-select mutiple-select2 apply-condition-item">
                        ${
                            applyConditionData &&
                            applyConditionData
                                .map((item) => {
                                    return /*html*/ `
                                <option value="${item.id}">${item.name}</option>
                            `;
                                })
                                .join("")
                        }
                    </select>
                </div>
            </div>
        `;
        return html;
    };

    // Hàm này chọn apply condition item
    init.chooseApplyConditionItem = () => {
        let selectConditions = [];

        $(document).on("change", ".apply-condition-item", function () {
            const _this = $(this);
            const selectedItems = _this.val() || [];
            let label = _this.select2("data");

            // Duyệt qua tất cả các phần tử đã chọn
            selectedItems.forEach((element, index) => {
                // Kiểm tra đã có condition nào đang chọn
                if (!selectConditions.includes(element)) {
                    selectConditions.push(element);
                    let html = "";

                    html = init.renderApplyConditionItemHtml(
                        label[index].text,
                        element
                    );

                    _this.parents(".apply-condition-wrapper").append(html);

                    setTimeout(() => {
                        init.promotionMutipleSelect2();
                    }, 200);
                }
            });

            // Lọc các apply condition child không cần thiết
            $(".apply-condition-child").each(function () {
                const _this = $(this);
                let className = _this.attr("class").split(" ").pop();
                if (!selectedItems.includes(className)) {
                    _this.remove();
                }
            });

            // Kiểm tra các apply condition child đã bị xoá khi bỏ select
            if ($(".apply-condition-child").length > selectedItems.length) {
                $(".apply-condition-child").each(function () {
                    const _this = $(this);
                    let className = _this.attr("class").split(" ").pop();
                    if (!selectedItems.includes(className)) {
                        _this.remove();
                    }
                });
            }

            selectConditions = selectConditions.filter((item) =>
                selectedItems.includes(item)
            );
        });
    };

    // hàm này render ra html apply conditon child
    init.renderApplyConditionItemHtml = (label = "", element) => {
        let data = [
            {
                id: "1",
                name: "Khách vip",
            },
            {
                id: "2",
                name: "Khách bán buôn",
            },
        ];

        let html = /*html*/ `
            <div class="border-bottom apply-condition-child pb-3 ${element}">
                <label for="" class="form-label text-primary fw-normal">${label}</label>
                <select class="form-select mutiple-select2" multiple name="" id="">
                    ${
                        data &&
                        data
                            .map((item) => {
                                return /*html*/ `
                                <option value="${item.id}">${item.name}</option>
                            `;
                            })
                            .join("")
                    }
                </select>
            </div>
        `;
        return html;
    };

    // Hàm này giúp lấy dữ liệu tìm kiếm
    init.promotionMutipleSelect2 = () => {
        $(".mutiple-select2").select2({
            minimunInputLength: 2,
            placeholder: "Click vào đây để lựa chọn...",
            // ajax: {
            //     url: "/ajax/attribute/getAttribute",
            //     type: "GET",
            //     dataType: "json",
            //     delay: 250,
            //     data: function (params) {
            //         let query = {
            //             search: params.term,
            //             option: option,
            //         };
            //         // Query parameters will be ?search=[term]
            //         return query;
            //     },
            //     processResults: function (data) {
            //         return {
            //             results: $.map(data, function (obj, i) {
            //                 return obj;
            //             }),
            //         };
            //     },
            // },
        });
    };

    init.setUpSelect2 = () => {
        $(".init-select2").select2();
    };

    init.checkCreatePromotionType = () => {
        let $row = $(".promotion-row-wrap").find(
            ".promotion-type-row-item:last-child"
        );
        const getLastInputValue = (selector) => {
            return formatCommasToNumber($row.find(selector + " input").val());
        };

        const orderAmountRangeFrom = getLastInputValue(
            ".order-amount-range-from"
        );
        const orderAmountRangeTo = getLastInputValue(".order-amount-range-to");

        // Kiểm tra giá trị đến phải lớn hơn giá trị từ
        if (orderAmountRangeTo <= orderAmountRangeFrom) {
            $row.find("input").addClass("is-invalid");
            setToast(
                "warning",
                "Vui lòng nhập giá trị đến lớn hơn giá trị từ."
            );
            return false;
        }
        $row.find("input").removeClass("is-invalid");
        return orderAmountRangeTo;
    };

    // Hàm này tạo ra khu vềc khi chọn promotion type
    init.createPromotionTypeRow = () => {
        $(document).on("click", ".create-promotion-type-btn", function () {
            let lastInputVal = init.checkCreatePromotionType();
            if (lastInputVal === false) {
                return;
            }
            let html = init.renderPromotionTypeRowHtml(lastInputVal);
            $(".promotion-row-wrap").append(html);
            init.setUpSelect2();
        });
    };
    // Hàm này xóa khu vềc khi chọn promotion type
    init.deletePromotionTypeRow = () => {
        $(document).on("click", ".delete-promotion-type-row", function () {
            if ($(".promotion-type-row-item").length > 1) {
                $(this).parents(".promotion-type-row-item").remove();
            }
        });
    };

    // Hàm này render ra promotion type html
    init.renderPromotionTypeRowHtml = (lastInputVal) => {
        let html = /*html*/ `
            <tr class="promotion-type-row-item">
                <td class="order-amount-range-from"> 
                    <input type="text" class="form-control text-end int" value="${formatToCommas(
                        +lastInputVal + 1
                    )}">
                </td>
                <td class="order-amount-range-to">
                    <input type="text" class="form-control text-end int" value="0">
                </td>
                <td class="discount-type">
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control text-end int me-1 "
                            value="0">

                        <select class="form-select init-select2 w-25 " name="">
                            <option value="cast">đ</option>
                            <option value="percent">%</option>
                        </select>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button"
                        class="btn btn-outline-secondary delete-promotion-type-row text-danger px-2">
                        <i class="icofont-trash fs-14 "></i>
                    </button>
                </td>
            </tr>
        `;
        return html;
    };

    // Hàm này bắt sự kiện change vào select promotion method và hiển thị ra promotion container
    init.renderOrderRangeContainer = () => {
        $(document).on("change", ".promotion-method", function () {
            const _this = $(this);
            const option = _this.val();
            switch (option) {
                case "0":
                    init.emptyPromotionContainer();
                    break;
                case "order_amount_range":
                    init.renderOrderAmountRange();
                    break;
                case "product_and_quantity":
                    init.renderProductAndQuantity();
                    break;
                default:
                    setAlertBasic(
                        "info",
                        "Lựa chọn đang trong phát triển, vui lòng chọn lựa chọn khác."
                    );
                    init.emptyPromotionContainer();
                    break;
            }
        });
    };

    // Trường hợp render ra order amount range
    init.renderOrderAmountRange = () => {
        let html = /*html*/ `
        <div class="card-body order-amount-range">
            <div class="table-responsive rounded-1">
                <table class="table">
                    <thead>
                        <tr>
                            <th class=" text-end ">Giá trị từ</th>
                            <th class=" text-end ">Giá trị đến </th>
                            <th class=" text-end ">Chiết khấu</th>
                            <th class=" text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="promotion-row-wrap">
                        <tr class="promotion-type-row-item">
                            <td class="order-amount-range-from">
                                <input type="text" name="amountFrom[]" class="form-control text-end int" value="0">
                            </td>
                            <td class="order-amount-range-to">
                                <input type="text" name="amountTo[]" class="form-control text-end int" value="0">
                            </td>
                            <td class="discount-type">
                                <div class="d-flex align-items-center">
                                    <input type="text" name="amountValue[]" class="form-control text-end int me-1 " value="0">

                                    <select class="form-select init-select2 w-25 " name="amountType[]">
                                        <option value="cast">đ</option>
                                        <option value="percent">%</option>
                                    </select>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn btn-outline-secondary delete-promotion-type-row text-danger px-2">
                                    <i class="icofont-trash fs-14 "></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button"
                class="btn btn-outline-success create-promotion-type-btn px-3 shadow-sm mt-2">Thêm
                điều kiện</button>
        </div>
        `;
        $(".promotion-container").html(html);
        init.setUpSelect2();
    };

    init.renderProductAndQuantity = () => {
        let selects = JSON.parse(
            $('input[name="select_product_and_quantity"').val()
        );
        let selectHtml = ``;
        for (const key in selects) {
            if (Object.hasOwnProperty.call(selects, key)) {
                const val = selects[key];
                selectHtml += `<option value="${key}">${val}</option>`;
            }
        }
        let html = /*html*/ `
        <div class="product-and-quantity mt-3">
                <div class="mb-4">
                    <label for="" class="form-label text-primary">Sản phẩm áp dụng</label>
                    <select name="" class="form-select select-product-and-quantity init-select2">
                    ${selectHtml}
                    </select>

                </div>

                <div class="table-responsive rounded-1">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class=" text-end w-45">Sản phẩm mua</th>
                                <th class=" text-end w-11">SL tối thiểu</th>
                                <th class=" text-end ">Giới hạn KM</th>
                                <th class=" text-end ">Chiết khấu</th>
                                <th class=" text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr class="">
                                <td class="">
                                    <div class="product-quantity-wrap">
                                        <div class="product-quantity-inner ">
                                            <div class="goods-list d-none">

                                            </div>
                                            <div class="search-wrap search-product-btn" data-bs-toggle="modal"
                                                data-bs-target="#find-product">
                                                <div class="icon-search ">
                                                    <i class="icofont-search-1"></i>
                                                </div>
                                                <div class="input-search">
                                                    <p>Chọn vào đây để tìm kiếm...</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                                <td class="">
                                    <input type="text" name="amountTo[]"
                                        class="form-control text-end int" value="1">
                                </td>
                                <td class="">
                                    <input type="text" name="amountTo[]"
                                        class="form-control text-end int" value="0">
                                </td>
                                <td class="discount-type">
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="amountValue[]"
                                            class="form-control text-end int me-1 " value="0">

                                        <select class="form-select init-select2 w-25 "
                                            name="amountType[]">
                                            <option value="cast">đ</option>
                                            <option value="percent">%</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-outline-secondary delete-promotion-type-row text-danger px-2">
                                        <i class="icofont-trash fs-14 "></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
        $(".promotion-container").html(html);
        setTimeout(() => {
            init.setUpSelect2();
        }, 500);
    };

    // Hàm này loại bỏ chọn apply condition
    init.emptyPromotionContainer = () => {
        $(".promotion-container").empty();
    };

    init.productQuantityList = () => {
        $(document).on(
            "click",
            ".product-quantity-wrap .search-product-btn",
            function () {
                let option = {
                    model: $(".select-product-and-quantity").val(),
                };

                init.sendProductSearchAjax(option);
            }
        );
    };

    // Hàm này load product ajax
    init.sendProductSearchAjax = (option) => {
        $.ajax({
            url: "/ajax/product/loadProductPromotion",
            type: "get",
            dataType: "json",
            data: option,
            beforeSend: function () {
                $(".search-product-result").html(`
                    <div class="loader-menu-model w-100 "></div>
                `);
            },
            success: function (response) {
                if (response.data.data.length > 0) {
                    init.fillToOject(response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
        });
    };

    init.fillToOject = (response) => {
        switch (response.model) {
            case "Product":
                init.renderProductQuantityListHtml(response.data);
                break;
            case "ProductCatalogue":
                init.renderProductCatalogueQuantityListHtml(response.data);
                break;
            default:
                break;
        }
    };

    // Hàm này render ra html product Quantity List Product
    init.renderProductCatalogueQuantityListHtml = (response) => {
        let html = response.data
            ?.map((item) => {
                let modelName = $(".select-product-and-quantity").val();
                let name = item.name;
                let id = item.id;
                let product_variant_id = item.product_variant_id ?? 0;

                let checked =
                    $(
                        `.goods-item.${`${modelName}_${id}_${product_variant_id}`}`
                    ).length > 0
                        ? "checked"
                        : "";

                return /*html*/ `
                    <div class="row product-item" data-objectid="${id}" data-model="${modelName}">
                        <div class="col-md-8">
                            <div class="product-item-info">
                                <div class="form-check">
                                    <input ${checked} class="form-check-input product-item-checkbox ${id}"
                                        type="checkbox"/>
                                </div>
                                <p class="mb-1 fs-16 ms-1 name">${name}</p>
                            </div>
                        </div>
                    </div>
                `;
            })
            .join("");
        if (response.last_page > 1) {
            html += init.renderProductQuantityListPagination(response.links);
        }
        $(".search-product-result").html(html);
    };

    // Hàm này render ra html product Quantity List Product
    init.renderProductQuantityListHtml = (data) => {
        let html = data.data
            ?.map((data) => {
                let modelName = $(".select-product-and-quantity").val();
                let variant_name = data.variant_name.split("-");
                let image = data.image;
                let sku = data.sku;
                let price = data.price;
                let product_variant_id = data.product_variant_id ?? 0;
                let product_id = data.id;
                let inventory = data.inventory ?? 0;
                let couldSell = data.couldSell ?? 0;

                let checked =
                    $(
                        `.goods-item.${`${modelName}_${product_id}_${product_variant_id}`}`
                    ).length > 0
                        ? "checked"
                        : "";

                return /*html*/ `
                <div class="row product-item" data-objectid="${product_id}" data-variantid="${product_variant_id}" data-model="${modelName}">
                        <div class="col-md-8">
                            <div class="product-item-info">
                                <div class="form-check">
                                    <input ${checked} class="form-check-input product-item-checkbox ${product_id}-${product_variant_id}" type="checkbox"/>
                                </div>
                                <div class="product-info">
                                    <div class="product-img">
                                        <img class="img-thumbnail"
                                            src="${image}"
                                            alt="${variant_name[0]}">
                                    </div>

                                    <div class="product-title">
                                        <p class="name">${
                                            variant_name[0]
                                        } - (Phiên bản:
                                                <span>
                                                    ${variant_name[1]}
                                                </span>)
                                        </p>
                                        
                                        <p>Mã SP: <span>${sku}</span></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product-price-stock">
                                <p class="price">${formatCurrency(
                                    price ?? 0
                                )}</p>
                                <div class="stock">
                                    <p>
                                        Tồn kho: <span>${inventory}</span>
                                    </p>
                                    <p>
                                        Có thể bán: <span>${couldSell}</span>
                                    </p>

                                </div>
                            </div>

                        </div>
                    </div>
        `;
            })
            .join("");
        if (data.last_page > 1) {
            html += init.renderProductQuantityListPagination(data.links);
        }
        $(".search-product-result").html(html);
        // init.checkChooseProductQuantity();
    };
    // Hàm này render ra html pagination
    init.renderProductQuantityListPagination = (data = []) => {
        let html =
            '<nav><ul class="pagination pagination-product-quantity mt-3">';

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

    // Hàm này get ra pagination product
    init.getPaginationProduct = () => {
        $(document).on(
            "click",
            ".pagination-product-quantity .page-link",
            function (event) {
                event.preventDefault();
                let _this = $(this);

                const url = new URL(_this.attr("href"));

                let option = {
                    model: $(".select-product-and-quantity").val(),
                    page: url.searchParams.get("page"),
                    keyword:
                        $(".search-product-wrap .input-product-search").val() ??
                        "",
                };

                init.sendProductSearchAjax(option);
            }
        );
    };
    // Hàm này search ra product
    init.seachProductQuantityListPagination = () => {
        let typingTimeout;
        $(document).on(
            "keyup",
            ".search-product-wrap .input-product-search",
            function () {
                let _this = $(this);
                let keyword = _this.val();

                let option = {
                    model: $(".select-product-and-quantity").val(),
                    keyword,
                };

                clearTimeout(typingTimeout);

                typingTimeout = setTimeout(function () {
                    init.sendProductSearchAjax(option);
                }, 200);
            }
        );
    };

    // Chọn các sản phẩm trong list
    var productItemChoose = [];
    init.chooseProductItem = () => {
        $(document).on("click", ".product-item", function () {
            let _this = $(this);
            let model = _this.data("model");
            let productId = _this.data("objectid");
            let name = _this.find(".name").text();
            let variantId = _this.data("variantid") ?? 0;
            let data = {
                model,
                product_id: productId,
                variant_id: variantId,
                name,
            };

            let isChecked = _this
                .find(".product-item-checkbox")
                .prop("checked");

            // Nếu checked, thêm vào mảng object, ngược lại loại bỏ
            if (!isChecked) {
                productItemChoose.push(data);
            } else {
                productItemChoose = productItemChoose.filter(
                    (item) =>
                        item.model !== model ||
                        item.product_id !== productId ||
                        item.variant_id !== variantId
                );
            }
            console.log(productItemChoose);

            _this.find(".product-item-checkbox").prop("checked", !isChecked);
        });
    };

    // Hàm render ra list sản phẩm đã chọn
    init.confirmProductPromotion = () => {
        $(document).on("click", ".confirm-product-promotion", function () {
            if ($(".product-item-checkbox:checked").length == 0) {
                return setToast("error", "Vui lòng chọn ít nhất 1 sản phẩm.");
            }
            let html =
                productItemChoose &&
                productItemChoose?.length > 0 &&
                productItemChoose
                    .map((item) => {
                        let modelName =
                            item.model +
                                "_" +
                                item.product_id +
                                "_" +
                                item.variant_id ?? 0;

                        return /*html*/ `
                        <div class="goods-item ${modelName}" data-model="${
                            item.model
                        }">
                            <span>${item.name}</span>
                            <button type="button" class="btn-close"></button>
                            <input type="hidden" name="object[id][]" value="${
                                item.product_id
                            }">
                            <input type="hidden" name="object[product_variant_id][]" value="${
                                item.variant_id ?? 0
                            }">
                        </div>
                        `;
                    })
                    .join("");
            html += /*html*/ `
                <div class="goods-item-2 last-child fw-bold search-product-btn" data-bs-toggle="modal"
                data-bs-target="#find-product">
                    Chọn vào đây để tìm kiếm...
                </div>
            `;
            $(".goods-list").html(html);
            init.checkGoodsListHide();
            $("#find-product").modal("hide");
        });
    };

    // Hàm này kiểm tra list sản phẩm có trống hay khong
    init.checkGoodsListHide = () => {
        if ($(".goods-list .goods-item").length <= 0) {
            $(".goods-list").addClass("d-none");
            $(".search-wrap").show();
        } else {
            $(".goods-list").removeClass("d-none");
            $(".search-wrap").hide();
        }
    };

    // Hàm này xoá goods item sản phẩm
    init.deleteGoodsItem = () => {
        $(document).on("click", ".goods-item .btn-close", function () {
            let _this = $(this);
            let productId = _this.siblings("input[name='object[id][]']").val();
            let variantId = _this
                .siblings("input[name='object[product_variant_id][]']")
                .val();
            let model = _this.closest(".goods-item").data("model");

            _this.closest(".goods-item").remove();

            // Lọc lại những gì đã chọn ở productItemChoose
            productItemChoose = productItemChoose.filter(
                (item) =>
                    item.product_id != productId ||
                    item.variant_id != variantId ||
                    item.model != model
            );

            // Bỏ chọn những gì đã xoá
            $(`.product-item`)
                .find(`.${productId}-${variantId}`)
                .prop("checked", false);

            init.checkGoodsListHide();
        });
    };

    // ChangeMethod
    init.changePromotionMethod = () => {
        $(document).on("change", ".select-product-and-quantity", function () {
            $(".goods-list").html("");
            productItemChoose = [];
            init.checkGoodsListHide();
        });
    };

    $(document).ready(function () {
        init.promotionNeverEnd();
        init.validateEndDate();
        init.promotionSource();
        init.promotionMutipleSelect2();
        init.promotionApplyCondition();
        init.chooseApplyConditionItem();
        init.createPromotionTypeRow();
        init.deletePromotionTypeRow();
        init.renderOrderRangeContainer();
        init.productQuantityList();
        init.getPaginationProduct();
        init.seachProductQuantityListPagination();
        init.chooseProductItem();
        init.confirmProductPromotion();
        init.deleteGoodsItem();
        init.changePromotionMethod();
    });
});

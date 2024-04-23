if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    // Hàm này tạo ra khu vực để tạo ra variant
    init.setUpProductVariant = () => {
        setTimeout(() => {
            if (!$(".turn-on-variant").is(":checked")) {
                $(".variant-wrap").hide();
            }
        });
        $(".turn-on-variant").on("change", function () {
            const _this = $(this);

            if (
                $('input[name="price"]').val() == "" ||
                $('input[name="sku"]').val() == ""
            ) {
                _this.prop("checked", false);
                return setToast(
                    "warning",
                    "Vui lòng nhập mã sản phẩm và giá bán sản phẩm."
                );
            }

            if (_this.is(":checked")) {
                $(".variant-wrap").show();
            } else {
                $(".variant-wrap").hide();
            }
        });
    };

    init.sortUI = () => {
        if ($(".sortable").length > 0) {
            $(".sortable").sortable();
        }

        if ($(".sortable").length > 0) {
            $(".sortable").disableSelection();
        }
    };

    // Hàm này giúp khởi tạo toàn bộ nice select
    init.niceSelect = () => {
        if ($(".init-nice-select").length > 0) {
            $(".init-nice-select").niceSelect();
        }
    };

    // Hàm này giúp xoá toàn bộ nice select
    init.destroyNiceSelect = () => {
        if ($(".init-nice-select").length > 0) {
            $(".init-nice-select").niceSelect("destroy");
        }
    };

    // Hàm này giúp thêm variant item
    init.addNewVarriant = () => {
        $(".add-variant").on("click", function () {
            $(".variant-body").append(init.renderVariantItem());
            $("table.table-variant thead").empty();
            $("table.table-variant tbody").empty();
            init.checkMaxAttributeGroup();
            init.disabledAttributeChoose();
        });
    };

    // Hàm này giúp xóa variant item
    init.deleteVariant = () => {
        $(".variant-body").on("click", ".delete-variant", function () {
            $(this).closest(".variant-item").remove();
            init.checkMaxAttributeGroup();
            init.createVariant();
        });
    };

    // Hàm này giúp render variant item
    init.renderVariantItem = () => {
        let catalogue = attributeCatalogues?.map((item) => {
            return `
                <option value="${item.id}">${item.name}</option>
            `;
        });

        let html = /*html*/ `
            <div class="row d-flex align-items-center variant-item">
                <div class="col-md-4">
                    <label class="form-label text-info">Chọn thuộc tính</label>
                    <select class="init-nice-select w-100 choose-attribute" name="attributeCatalogue[]">
                        <option selected>Chọn thuộc tính</option>
                        ${catalogue}
                    </select>

                </div>
                <div class="col-md-7">
                    <label class="form-label text-info">Chọn giá trị tìm kiếm (nhập 2 từ để tìm
                        kiếm)</label>
                        
                        <div class="select-variant-wrap">
                            <input type="text" disabled class="form-control" name="attribute[]" />
                        </div>
                </div>
                <div class="col-md-1 mt-25 ">
                    <button type="button" class="btn btn-danger py-2 delete-variant">
                        <i class="icofont-trash fs-6 text-white "></i>
                    </button>
                </div>
            </div>
        `;
        return html;
    };

    init.disabledAttributeChoose = () => {
        $(".choose-attribute option").prop("disabled", false);

        $(".choose-attribute").each(function () {
            const currentSelect = $(this);
            const currentValue = currentSelect.val();

            if (currentValue !== "0") {
                $(".choose-attribute")
                    .not(currentSelect)
                    .find(`option[value="${currentValue}"]`)
                    .prop("disabled", true);
            }
        });

        init.destroyNiceSelect();
        init.niceSelect();
    };
    // Hàm này giúp chọn attribute group và đổ ra attribute tương ứng
    init.chooseVariantGroup = () => {
        $(document).on("change", ".choose-attribute", function () {
            const _this = $(this);
            const attributeCatalogueId = _this.val();
            if (attributeCatalogueId != 0) {
                _this
                    .parents(".col-md-4")
                    .siblings(".col-md-7")
                    .find(".select-variant-wrap")
                    .html(init.select2Variant(attributeCatalogueId));

                $(".select-variant").each(function () {
                    init.getSelect2($(this));
                });
            } else {
                $(".select-variant-wrap").html(
                    ` <input type="text" disabled class="form-control" name="attribute[]" />`
                );
            }
            init.disabledAttributeChoose();
        });
    };

    // Hàm này tạo ra ô select attribute value
    init.select2Variant = (attributeCatalogueId) => {
        let html = /*html*/ `
            <select class="form-select form-control select-variant variant-${attributeCatalogueId}" name="attribute[${attributeCatalogueId}][]" multiple data-catalogue-id="${attributeCatalogueId}"></select>
        `;
        return html;
    };

    // Hàm này giúp lấy dữ liệu tìm kiếm attribute
    init.getSelect2 = (element) => {
        let option = {
            attributeCatalogueId: element.data("catalogue-id"),
        };
        $(element).select2({
            minimunInputLength: 2,
            placeholder: "Nhập tối thiểu 2 ký tự để tìm kiếm",
            ajax: {
                url: "/ajax/attribute/getAttribute",
                type: "GET",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    let query = {
                        search: params.term,
                        option: option,
                    };

                    // Query parameters will be ?search=[term]
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj, i) {
                            return obj;
                        }),
                    };
                },
            },
        });
    };

    // Hàm này giúp tạo ra select multiple attribute
    init.setUpSelectMultiple = () => {
        return new Promise((resolve, reject) => {
            const selectVariants = $(".select-variant");
            const requests = [];

            selectVariants.each(function () {
                const _this = $(this);
                const attributeCatalogueId = _this.data("catalogue-id");

                if (attributeForm !== "") {
                    const request = new Promise((resolve, reject) => {
                        $.ajax({
                            url: "/ajax/attribute/loadAttribute",
                            dataType: "json",
                            type: "get",
                            data: {
                                attribute: attributeForm,
                                attributeCatalogueId,
                            },
                            success: function (data) {
                                if (data.length > 0) {
                                    data.forEach(function (value) {
                                        let option = new Option(
                                            value.text,
                                            value.id,
                                            true,
                                            true
                                        );
                                        _this.append(option);
                                    });
                                }
                                resolve(); // Giải quyết Promise khi yêu cầu AJAX thành công
                            },
                            error: function (xhr, exception) {
                                console.log(xhr.responseText);
                                resolve(); // Giải quyết Promise khi có lỗi
                            },
                        });
                    });
                    requests.push(request);
                }

                init.getSelect2(_this);
            });

            // Giải quyết tất cả các Promise khi tất cả các yêu cầu đã hoàn thành
            Promise.all(requests).then(() => {
                selectVariants.trigger("change"); // Kích hoạt sự kiện "change" sau khi tất cả các yêu cầu AJAX đã hoàn thành
                resolve(); // Giải quyết Promise của hàm setUpSelectMultiple khi tất cả các yêu cầu AJAX đã hoàn thành
            });
        });
    };

    // Hàm này giúp đổ giữ liệu vào input khi submit form
    init.productVariant = () => {
        if (variantForm !== "") {
            $(".variant-row").each(function (index, value) {
                let _this = $(this);
                let inputHiddenFields = [
                    {
                        name: "variant[quantity][]",
                        class: "variant_quantity",
                        value: variantForm?.quantity[index],
                    },
                    {
                        name: "variant[sku][]",
                        class: "variant_sku",
                        value: variantForm?.sku[index],
                    },
                    {
                        name: "variant[price][]",
                        class: "variant_price",
                        value: variantForm?.price[index],
                    },
                    {
                        name: "variant[barcode][]",
                        class: "variant_barcode",
                        value: variantForm?.barcode[index],
                    },
                    {
                        name: "variant[file_name][]",
                        class: "variant_filename",
                        value: variantForm?.file_name[index],
                    },
                    {
                        name: "variant[file_url][]",
                        class: "variant_fileurl",
                        value: variantForm?.file_url[index],
                    },
                    {
                        name: "variant[album][]",
                        class: "variant_album",
                        value: variantForm?.album[index],
                    },
                ];
                let albumArr = variantForm?.album[index]?.split(",");

                inputHiddenFields.forEach((inputHiddenField) => {
                    _this
                        .find(`input[name="${inputHiddenField.name}"]`)
                        .val(inputHiddenField.value);
                });

                _this
                    .find(".td-quantity")
                    .text(formatToCommas(variantForm.quantity[index] ?? "-"));
                _this
                    .find(".td-price")
                    .text(formatToCommas(variantForm.price[index] ?? "-"));
                _this.find(".td-sku").text(variantForm.sku[index]);

                _this
                    .find(".img-variant-src")
                    .attr(
                        "src",
                        (albumArr && albumArr[0]) ||
                            "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png"
                    );
            });
        }
    };

    // Hàm này giúp check max attribute group khi vượt quá attributes sẽ ẩn nút add
    init.checkMaxAttributeGroup = () => {
        let variantItem = $(".variant-item").length;
        if (variantItem == attributeCatalogues?.length) {
            $(".add-variant").hide();
        } else {
            $(".add-variant").show();
        }
    };

    // Hàm này giúp tạo ra variant
    init.createVariant = () => {
        let attributes = []; //Luu cac gia tri
        let variants = []; //Luu cac id
        let attributeTitle = []; //luu cac heading name

        $(".variant-item").each(function () {
            let _this = $(this);
            let attr = [];
            let attrVariant = [];

            const attributeCatalogueId = _this.find(".choose-attribute").val();
            const optionText = _this
                .find(".choose-attribute option:selected")
                .text();
            const attribute = _this
                .find(".variant-" + attributeCatalogueId)
                .select2("data");

            for (let i = 0; i < attribute.length; i++) {
                const element = attribute[i];
                let items = {};
                let itemsVariant = {};

                items[optionText] = element.text;
                itemsVariant[attributeCatalogueId] = element.id;
                attr.push(items);
                attrVariant.push(itemsVariant);
            }
            attributes.push(attr);
            attributeTitle.push(optionText);
            variants.push(attrVariant);
        });

        variants = variants.reduce((acc, cur) => {
            // Làm phẳng và kết hợp các object từ mảng attributes
            return acc.flatMap((d) => cur.map((e) => ({ ...d, ...e })));
        });

        attributes = attributes.reduce((acc, cur) => {
            // Làm phẳng và kết hợp các object từ mảng attributes
            return acc.flatMap((d) => cur.map((e) => ({ ...d, ...e })));
        });

        // Tạo ra thead
        init.createTableHeader(attributeTitle);

        // Tạo ra row
        let existingClasses = [];
        attributes.forEach((item, index) => {
            let $row = init.createVariantRow(item, variants[index]);
            let classModified =
                "tr-variant-" +
                Object.values(variants[index]).join(", ").replace(/, /g, "-");
            existingClasses.push(classModified);

            if (
                !$("table.table-variant tbody tr.variant-row").hasClass(
                    classModified
                )
            ) {
                $("table.table-variant tbody").append($row);
            }
        });

        // Xoá variant không có trong existingClasses
        $("table.table-variant tbody tr.variant-row")
            .not("." + existingClasses.join(", ."))
            .remove();
    };

    // Hàm này giúp tạo ra theadEle
    init.createTableHeader = (attributeTitle) => {
        $("table.table-variant thead").html(/*html*/ `
            <tr>
                <th class="table-dark">Hình ảnh</th>
                ${attributeTitle
                    .map((title) => `<th class="table-dark">${title}</th>`)
                    .join("")}
                <th class="table-dark">Số lượng</th>
                <th class="table-dark">Giá tiền</th>
                <th class="table-dark">SKU</th>
                <th class="table-dark"></th>
            </tr>
        `);
    };

    // Hàm này giúp tạo ra từng dòng phiên bản
    init.createVariantRow = (attributeItem, variantItem) => {
        const attributeString = Object.values(attributeItem).join(", ");
        const attributeId = Object.values(variantItem).join(", ");

        let classModified = attributeId.replace(/, /g, "-");

        const valueAttr = Object.values(attributeItem)
            .map((value) => `<td class="td-attribute">${value}</td>`)
            .join("");

        const mainPriceVal = $('input[name="price"]').val();
        const mainSkuVal = $('input[name="sku"]').val() + "-" + classModified;

        let attributeRows = /*html*/ `
                <tr class="variant-row tr-variant-${classModified}">
                    <td scope="row">
                        <span class="img-variant">
                            <img class="img-thumbnail img-contain img-target img-fluid img-variant-src"
                                src="https://www.eclosio.ong/wp-content/uploads/2018/08/default.png"
                                alt="image-default">
                        </span>
                    </td>
                    ${valueAttr}
                    <td class="td-quantity">-</td>
                    <td class="td-price">${mainPriceVal}</td>
                    <td class="td-sku">${mainSkuVal}</td>
                    <td class="d-none td-variant">
                        <input type="hidden" name="variant[quantity][]" class="variant_quantity" >
                        <input type="hidden" name="variant[sku][]" class="variant_sku" value="${mainSkuVal}">
                        <input type="hidden" name="variant[price][]" class="variant_price" value="${mainPriceVal}">
                        <input type="hidden" name="variant[barcode][]" class="variant_barcode">
                        <input type="hidden" name="variant[file_name][]" class="variant_filename">
                        <input type="hidden" name="variant[file_url][]" class="variant_fileurl">
                        <input type="hidden" name="variant[album][]" class="variant_album">
                        <input type="hidden" name="productVariant[id][]" value="${attributeId}">
                        <input type="hidden" name="productVariant[name][]" value="${attributeString}">
                    </td>
                    <td class="text-center ">
                        <button type="button" class="btn btn-outline-secondary text-danger px-2 delete-variant-row">
                            <i class="icofont-trash fs-14 "></i>
                        </button>
                    </td>
                </tr>`;

        // Kiểm tra nếu có class này rồi sẽ k thêm vào
        return attributeRows;
    };

    init.deleteVariantRow = () => {
        $(document).on("click", ".delete-variant-row", function () {
            init.closeUpdateVariantBox();
            $(this).closest(".variant-row").remove();
        });
    };

    // Hàm này bắt sự kiện khi click vào thẻ tr variant muốn cập nhập
    init.updateVariant = () => {
        $(document).on("click", ".variant-row", function () {
            const _this = $(this);
            if (!_this.siblings().hasClass("active")) {
                _this.siblings().removeClass("active");
                _this.addClass("active");
            }
            let variantData = {};
            _this
                .find('.td-variant input[type=hidden][class^="variant_"]') //Trong CSS, các toán tử ^= được sử dụng để chọn các phần tử dựa trên các thuộc tính của chúng.
                .each(function () {
                    let className = $(this).attr("class");
                    variantData[className] = $(this).val();
                });

            let updateVariantBox = init.updateVariantHtml(variantData);
            if ($(".update-variant-wrap").length == 0) {
                _this.after(updateVariantBox);
            }
        });
    };

    // Hàm này bắt sự kiện khi chọn attribute để tạo ra variant
    init.createProductVariant = () => {
        $(".variant-body").on("change", ".select-variant", function () {
            let _this = $(this);
            init.createVariant();
        });
    };

    init.variantAlbumList = (album) => {
        if (album.length > 0) {
            return album
                .map((albumUrl) => {
                    return `
                    <div class="col-lg-2 album-variant-item">
                        <div class="position-relative ">
                            <img class="img-thumbnail image-album h-140" src="${albumUrl}" alt="${albumUrl}">
                            <span class="position-absolute icon-delete-album-variant">
                                <i class="icofont-ui-delete"></i>
                            </span>
                            <input type="hidden" name="variantAlbum[]" value="${albumUrl}">
                        </div>
                    </div>
                    `;
                })
                .join("");
        }
        return "";
    };

    // Hàm này render ra phần cập nhập thông tin variant HTML
    init.updateVariantHtml = (variantData) => {
        let variantAlbum =
            variantData.variant_album && variantData.variant_album.split(",");
        let variantAlbumItem = init.variantAlbumList(variantAlbum);

        let html = /*html*/ `
        <tr class="update-variant-wrap">
            <td colspan="100">
                <div class="card-create">
                    <div class="card-header py-3 bg-transparent">
                        <div
                            class="d-flex justify-content-between align-items-center border-bottom  py-3 border-top"
                        >
                            <h6 class="mb-0 fw-bold text-info ">Cập nhập thông tin phiên bản</h6>
                            <div>
                                <button type="button" class="btn btn-danger text-white me-2 cancel-update-variant">
                                    Huỷ bỏ
                                </button>
                                <button type="button" class="btn btn-success  text-white save-update-variant">
                                    Lưu lại
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div
                            class="card-header py-0  bg-transparent border-bottom-0"
                        >
                            <div
                                class="d-flex justify-content-between align-content-center "
                            >
                                <div>
                                    <h6 class="mb-0 fw-bold ">Album</h6>
                                </div>
                                <a
                                    href=""
                                    class="form-label link-primary upload-variant-picture"
                                    data-target="album"
                                    >Chọn ảnh album</a
                                >
                            </div>
                        </div>
                        <div class="card-body">
                            <div
                                class="row click-to-upload-variant-area px-3 ${
                                    variantData.variant_album != ""
                                        ? "d-none"
                                        : ""
                                }"
                            >
                                <div class="click-to-upload upload-variant-picture mb-4 ">
                                    <i class="icofont-upload-alt"></i>
                                    <p class="mb-0 mt-2">
                                    Sử dụng nút chọn ảnh hoặc chọn vào đây để thêm hình ảnh.
                                    </p>
                                </div>
                            </div>

                            <div
                                class="row g-4 align-items-center sortable upload-image-variant-list"
                            >${
                                variantData.variant_album != ""
                                    ? variantAlbumItem
                                    : ""
                            }</div>

                            <div class="row pt-4 d-flex align-items-center ">
                                <div class="col-md-2">
                                    <label class="form-label"
                                        >Quản lý tồn kho</label
                                    >
                                    <div class="checkbox-wrapper-35">
                                        <input
                                            name="switch"
                                            id="switch"
                                            type="checkbox"
                                            class="switch switch-variant"
                                            ${
                                                variantData.variant_quantity !=
                                                ""
                                                    ? "checked"
                                                    : ""
                                            }
                                        />
                                        <label for="switch">
                                            <span class="switch-x-text"
                                                >Trạng thái
                                            </span>
                                            <span class="switch-x-toggletext">
                                                <span class="switch-x-unchecked"
                                                    ><span
                                                        class="switch-x-hiddenlabel"
                                                        >Unchecked: </span
                                                    >Tắt</span
                                                >
                                                <span class="switch-x-checked"
                                                    ><span
                                                        class="switch-x-hiddenlabel"
                                                        >Checked: </span
                                                    >Bật</span
                                                >
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="row text-end ">
                                        <div class="col-md-3">
                                            <div>
                                                <label class="form-label"
                                                    >Số lượng</label
                                                >
                                                <input
                                                    type="text"
                                                    ${
                                                        variantData.variant_quantity !=
                                                        ""
                                                            ? ""
                                                            : "disabled"
                                                    }
                                                    class="form-control disabled int text-end "
                                                    name="variant_quantity"
                                                    value="${
                                                        variantData.variant_quantity
                                                    }"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div>
                                                <label class="form-label"
                                                    >SKU</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control text-end "
                                                    name="variant_sku"
                                                    value="${
                                                        variantData.variant_sku
                                                    }"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div>
                                                <label class="form-label"
                                                    >Giá tiền</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control int text-end"
                                                    name="variant_price"
                                                    value="${formatToCommas(
                                                        variantData.variant_price
                                                    )}"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div>
                                                <label class="form-label"
                                                    >Barcode</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control text-end "
                                                    name="variant_barcode"
                                                    value="${
                                                        variantData.variant_barcode
                                                    }"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 d-flex align-items-center ">
                                <div class="col-md-2">
                                    <label class="form-label">Quản lý file</label>
                                    <div class="checkbox-wrapper-35">
                                        <input
                                            value=""
                                            name="switch"
                                            id="switch-2"
                                            type="checkbox"
                                            class="switch switch-variant"
                                            ${
                                                variantData.variant_filename !=
                                                    "" ||
                                                variantData.variant_fileurl !=
                                                    ""
                                                    ? "checked"
                                                    : ""
                                            }
                                        />
                                        <label for="switch-2">
                                            <span class="switch-x-text"
                                                >Trạng thái
                                            </span>
                                            <span class="switch-x-toggletext">
                                                <span class="switch-x-unchecked"
                                                    ><span
                                                        class="switch-x-hiddenlabel"
                                                        >Unchecked: </span
                                                    >Tắt</span
                                                >
                                                <span class="switch-x-checked"
                                                    ><span
                                                        class="switch-x-hiddenlabel"
                                                        >Checked: </span
                                                    >Bật</span
                                                >
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="row text-end">
                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-label"
                                                    >Tên file</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control disabled text-end "
                                                    ${
                                                        variantData.variant_filename !=
                                                        ""
                                                            ? ""
                                                            : "disabled"
                                                    }
                                                    name="variant_file_name"
                                                    value="${
                                                        variantData.variant_filename
                                                    }"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-label"
                                                    >Đường dẫn</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control disabled text-end "
                                                    ${
                                                        variantData.variant_fileurl !=
                                                        ""
                                                            ? ""
                                                            : "disabled"
                                                    }
                                                    name="variant_file_url"
                                                    value="${
                                                        variantData.variant_fileurl
                                                    }"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>    
        `;

        return html;
    };

    // Hàm này giúp đóng update variant
    init.closeUpdateVariantBox = () => {
        $(".variant-row").removeClass("active");
        $(".update-variant-wrap").remove();
    };
    // Hàm này giúp huỷ bỏ update variant
    init.cancelUpdateVariant = () => {
        $(document).on("click", ".cancel-update-variant", function () {
            init.closeUpdateVariantBox();
        });
    };

    // Hàm này giúp lưu lại update variant
    init.saveUpdateVariant = () => {
        $(document).on("click", ".save-update-variant", function () {
            let _this = $(this);
            // $(".update-variant-area").empty();
            const variant = {
                quantity: $('input[name="variant_quantity"]').val(),
                price: $('input[name="variant_price"]').val(),
                sku: $('input[name="variant_sku"]').val(),
                barcode: $('input[name="variant_barcode"]').val(),
                filename: $('input[name="variant_file_name"]').val(),
                fileurl: $('input[name="variant_file_url"]').val(),
                album: $('input[name="variantAlbum[]"]')
                    .map(function () {
                        return $(this).val();
                    })
                    .get(),
            };

            $.each(variant, function (key, value) {
                $(`.variant-row.active .variant_${key}`).val(value);
            });

            init.previewVariantTd(variant);
            init.closeUpdateVariantBox();
        });
    };

    // Hàm này giúp hiển thị thông tin vào td variant
    init.previewVariantTd = (variant) => {
        let option = {
            quantity: variant.quantity,
            price: variant.price,
            sku: variant.sku,
            image: variant?.album[0]
                ? variant.album[0]
                : "https://www.eclosio.ong/wp-content/uploads/2018/08/default.png",
        };
        $.each(option, function (key, value) {
            $(`.variant-row.active .td-${key}`).text(value ?? "");
        });
        $(`.variant-row.active .img-variant-src`).attr("src", option.image);
    };

    // Hàm này bắt sự kiện nhấn vào nút upload ảnh variant
    init.uploadVariantAlbum = () => {
        $(document).on("click", ".upload-variant-picture", function (e) {
            e.preventDefault();
            const type = "Images";

            init.browseServerAlbumVariant(type);
        });
    };

    // Hàm này giúp hiện ra popup upload ảnh vào server
    init.browseServerAlbumVariant = (type) => {
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
               <div class="col-lg-2 album-variant-item">
                   <div class="position-relative ">
                       <img class="img-thumbnail image-album"
                           src="${image}" alt="${image}">
                       <span class="position-absolute icon-delete-album-variant">
                           <i class="icofont-ui-delete"></i>
                       </span>
                       <input type="hidden" name="variantAlbum[]" value="${image}">
                   </div>
               </div>
               `;
            }
            $(".click-to-upload-variant-area").addClass("d-none");
            $(".upload-image-variant-list").removeClass("d-none");
            $(".upload-image-variant-list").append(html);
        };
        finder.popup();
        init.sortUI();
    };
    // Hàm này giúp xoá ảnh variant album
    init.deletePictureVariantAlbum = () => {
        $(document).on("click", ".icon-delete-album-variant", function () {
            $(this).parent().parent().remove();

            if ($(".album-variant-item").length <= 0) {
                $(".click-to-upload-variant-area").removeClass("d-none");
                $(".upload-image-variant-list").addClass("d-none");
            }
        });
    };

    // Hàm này giúp thay đổi trạng thái của quản lý file và quản lý tồn kho
    init.swithChange = () => {
        $(document).on("change", ".switch-variant", function () {
            const _this = $(this);
            const isChecked = _this.prop("checked");
            const targetElements = $(this)
                .parents(".col-md-2")
                .siblings(".col-md-10")
                .find(".disabled");

            if (isChecked) {
                targetElements.removeAttr("disabled");
            } else {
                targetElements.attr("disabled", "disabled");
            }
        });
    };

    $(document).ready(function () {
        init.setUpProductVariant();
        init.addNewVarriant();
        init.deleteVariant();
        init.niceSelect();
        init.chooseVariantGroup();
        init.createProductVariant();
        init.uploadVariantAlbum();
        init.deletePictureVariantAlbum();
        init.swithChange();
        init.updateVariant();
        init.saveUpdateVariant();
        init.cancelUpdateVariant();
        init.deleteVariantRow();
        init.setUpSelectMultiple()
            .then(() => {
                init.productVariant();
            })
            .catch((error) => {
                console.log(error);
            });
    });
});

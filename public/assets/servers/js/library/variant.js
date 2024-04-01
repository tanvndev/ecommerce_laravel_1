if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function () {
    "use strict";
    var init = {};

    init.niceSelect = () => {
        if ($(".init-nice-select").length > 0) {
            $(".init-nice-select").niceSelect();
        }
    };

    init.destroyNiceSelect = () => {
        if ($(".init-nice-select").length > 0) {
            $(".init-nice-select").niceSelect("destroy");
        }
    };

    init.addNewVarriant = () => {
        $(".add-variant").on("click", function () {
            $(".variant-body").append(init.renderVariantItem());
            init.checkMaxAttributeGroup();
            init.disabledAttributeChoose();
        });
    };

    init.deleteVariant = () => {
        $(".variant-body").on("click", ".delete-variant", function () {
            $(this).closest(".variant-item").remove();
            init.checkMaxAttributeGroup();
        });
    };

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
                                    <select class="init-nice-select w-100 choose-attribute" name="" id="">
                                        <option selected>Chọn thuộc tính</option>
                                        ${catalogue}
                                    </select>

                                </div>
                                <div class="col-md-7">
                                    <label class="form-label text-info">Chọn giá trị tìm kiếm (nhập 2 từ để tìm
                                        kiếm)</label>
                                        <div class="select-variant-wrap">
                                            <input type="text" disabled class="form-control" name="" />
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
    init.chooseVariantGroup = () => {
        $(".variant-body").on("change", ".choose-attribute", function () {
            const _this = $(this);
            let attributeCatalogueId = _this.val();
            if (attributeCatalogueId) {
                $(".select-variant-wrap").empty();

                $(".select-variant-wrap").html(
                    init.select2Variant(attributeCatalogueId)
                );
                $(".select-variant").each(function () {
                    init.getSelect2($(this));
                });
            } else {
                $(".select-variant-wrap").html(
                    ` <input type="text" disabled class="form-control" name="" />`
                );
            }
            init.disabledAttributeChoose();
        });
    };

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

    init.setUpProductVariant = () => {
        // setTimeout(() => {
        //     $(".variant-wrap").hide();
        // });
        $(".turn-on-variant").on("change", function () {
            const _this = $(this);

            if (_this.is(":checked")) {
                $(".variant-wrap").show();
            } else {
                $(".variant-wrap").hide();
            }
        });
    };

    init.checkMaxAttributeGroup = () => {
        let variantItem = $(".variant-item").length;
        if (variantItem == attributeCatalogues?.length) {
            $(".add-variant").hide();
        } else {
            $(".add-variant").show();
        }
    };

    init.select2Variant = (attributeCatalogueId) => {
        let html = /*html*/ `
            <select class="form-select form-control select-variant" name="attribute[${attributeCatalogueId}][]" multiple data-catalogue-id="${attributeCatalogueId}"></select>
        `;
        return html;
    };

    $(document).ready(function () {
        init.setUpProductVariant();
        init.addNewVarriant();
        init.deleteVariant();
        init.niceSelect();
        init.chooseVariantGroup();
    });
});

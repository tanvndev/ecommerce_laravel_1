if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.amountRange = () => {
        const $sliderRange = $("#slider-range");
        const $amountStart = $("#amount-start");
        const $amountEnd = $("#amount-end");

        $sliderRange.slider({
            range: true,
            min: 0,
            max: 100000000,
            values: [0, 100000000],
            slide: function (event, ui) {
                $amountStart.val(formatToCommas(ui.values[0]) + "₫");
                $amountEnd.val(formatToCommas(ui.values[1]) + "₫");
            },
            change: function (event, ui) {
                $(".amount-range.filtering").trigger("change");
            },
        });

        $amountStart.val(
            formatToCommas($sliderRange.slider("values", 0)) + "₫"
        );
        $amountEnd.val(formatToCommas($sliderRange.slider("values", 1)) + "₫");
    };

    init.filter = () => {
        let timer;

        $(document).on("change", ".filtering", function () {
            clearTimeout(timer);

            timer = setTimeout(() => {
                init.sendAjaxFilter();
            }, 300);
        });
    };

    init.sendAjaxFilter = () => {
        let payload = init.filterPayload();
        $.ajax({
            url: "/ajax/product/filter",
            type: "GET",
            data: payload,
            success: function (response) {
                console.log(response);
                // Xử lý khi gửi thành công
                if (response?.code == 200) {
                    const html = init.renderFilterProduct(response);
                    $(".product-filter-list").html(html);
                    $(".product-pagination").html(response.paginate);
                    return true;
                }
            },
            error: function (xhr, status, error) {
                // Xử lý khi có lỗi xảy ra
                let errors = JSON.parse(xhr.responseText);
            },
        });
    };

    init.renderFilterProduct = (response) => {
        if (response.data.data.length <= 0) {
            return `
                <div class="text-center">
                    <img src="/public/userfiles/image/other/icon-empty-cart.png" alt="not-cart">
                    <p>Chưa có sản phẩm nào.</p>
                </div>
            `;
        }

        const html = response.data.data
            .map((item) => {
                const album = item.variant_album
                    ? item.variant_album.split(",")
                    : [];
                const name = item.variant_name || item.language[0].pivot.name;
                const image =
                    album[0] && album[0] != "" ? album[0] : item.image;
                const price = item.price;
                const priceSale = item.discounted_price;
                const discount = priceSale
                    ? ((1 - priceSale / price) * 100).toFixed(0)
                    : 0;
                const canonical =
                    item.code && item.code != ""
                        ? `${item.canonical}?attribute_id=${item.code}`
                        : item.canonical;

                return `
                <div class="col-xl-4 col-sm-6">
                    <div class="axil-product product-style-one mb--30">
                        <div class="thumbnail">
                            <a href="${canonical}" title="${name}">
                                <img src="${image}" alt="${name}">
                            </a>
                            ${
                                discount > 0
                                    ? `
                            <div class="label-block label-right product-variant-disocunt">
                                <div class="product-badget">Giảm ${discount}%</div>
                            </div>`
                                    : ""
                            }
                            <div class="product-hover-action">
                                <ul class="cart-action">
                                    <li class="wishlist"><a href="wishlist.html"><i class="far fa-heart"></i></a></li>
                                    <li class="select-option">
                                        <a data-bs-toggle="modal" data-bs-target="#quick-view-modal" href="${canonical}" title="${name}">
                                            Thêm vào giỏ hàng
                                        </a>
                                    </li>
                                    <li class="quickview"><a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="inner">
                                <h5 class="title"><a href="${canonical}" title="${name}">${name}</a></h5>
                                <div class="product-price-variant">
                                    ${
                                        price != priceSale
                                            ? `
                                        <span class="price current-price">${formatCurrency(
                                            priceSale
                                        )}</span>
                                        <span class="price old-price">${formatCurrency(
                                            price
                                        )}</span>
                                    `
                                            : `<span class="price current-price">${formatCurrency(
                                                  price
                                              )}</span>`
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            })
            .join("");

        return html;
    };

    init.filterPayload = () => {
        const getCheckedValues = (selector) =>
            $(selector)
                .map(function () {
                    return $(this).val();
                })
                .get();

        const rate = getCheckedValues('input[name="rate[]"]:checked');
        const minPrice = $("#amount-start").val();
        const maxPrice = $("#amount-end").val();
        const product_catalogue_id = $("#product_catalogue_id").val();
        const sort = $("#sort").val();
        const perpage = $("#perpage").val();

        let payload = {
            perpage: 1,
            sort: "desc",
            rate: rate,
            price: {
                min: minPrice,
                max: maxPrice,
            },
            attributes: {},
            product_catalogue_id: product_catalogue_id,
        };

        $('input[name="attribute[]"]:checked').each(function () {
            const _this = $(this);
            const attributeId = _this.val();
            const attributeCatalogueId = _this.data("catalogue");

            if (!payload.attributes.hasOwnProperty(attributeCatalogueId)) {
                payload.attributes[attributeCatalogueId] = [];
            }
            payload.attributes[attributeCatalogueId].push(attributeId);
        });

        return payload;
    };

    $(document).ready(function () {
        init.amountRange();
        init.filter();
    });
});

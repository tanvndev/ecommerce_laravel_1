if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.slickActive = () => {
        $(".product-small-thumb").slick({
            infinite: false,
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            focusOnSelect: true,
            vertical: true,
            speed: 800,
            asNavFor: ".product-large-thumbnail",
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        vertical: false,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        vertical: false,
                        slidesToShow: 4,
                    },
                },
            ],
        });

        $(".product-large-thumbnail").slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            speed: 800,
            draggable: false,
            asNavFor: ".product-small-thumb",
        });
    };

    init.slickAblumActive = () => {
        $(".product-small-thumb-3").slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            focusOnSelect: true,
            vertical: true,
            speed: 800,
            draggable: false,
            swipe: false,
            asNavFor: ".product-large-thumbnail-3",
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        vertical: false,
                    },
                },
            ],
        });

        $(".product-large-thumbnail-3").slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            speed: 800,
            draggable: false,
            swipe: false,
            asNavFor: ".product-small-thumb-3",
        });
    };

    init.zoomGalleryActive = () => {
        if ($(".zoom-gallery").length) {
            $(".zoom-gallery").each(function () {
                $(this).magnificPopup({
                    delegate: "a.popup-zoom",
                    type: "image",
                    gallery: {
                        enabled: true,
                    },
                });
            });
        }
    };

    init.selectVariant = () => {
        $(document).on("click", ".choose-attribute", function () {
            const $this = $(this);
            $this.siblings().removeClass("active");
            $this.toggleClass("active");

            init.handleAttribute();
        });
    };

    init.setUpVariantUrl = (response, attribute_id) => {
        // Create a new URL with the attribute_id parameter
        let newUrl = new URL(window.location.href);
        newUrl.searchParams.set("attribute_id", attribute_id);

        // Update the URL without reloading the page
        history.pushState({}, null, newUrl.toString());
    };

    init.handleAttribute = () => {
        // Kiem tra xem da chon thuoc tinh chua
        const allVariantsSelected = $(".product-variation")
            .toArray()
            .every(function (variant) {
                return $(variant).find(".choose-attribute.active").length === 1;
            });

        if (!allVariantsSelected) {
            $(".add-to-cart .btn").addClass("disabled");
            return;
        }

        const attributeIds = $(".product-variation .choose-attribute.active")
            .map(function () {
                return $(this).data("attribute-id");
            })
            .get();
        $(".add-to-cart .btn").removeClass("disabled");

        $.ajax({
            type: "GET",
            url: "/ajax/product/loadVariant",
            data: {
                attribute_id: attributeIds,
                product_id: $('input[name="product_id"]').val(),
            },
            dataType: "json",
            beforeSend: function () {
                $(".add-to-cart .btn").removeClass("disabled");
            },
            success: function (response) {
                if (!response) {
                    return false;
                }
                let album = response?.album.split(",");
                init.setUpVariantAlbum(album);
                init.setUpVariantName(response);
                init.setUpVariantPrice(response);
                init.setUpVariantUrl(response, attributeIds);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
                // Xử lý lỗi nếu có
            },
            complete: function () {
                // Thực hiện các hành động sau khi ajax hoàn thành (thành công hoặc thất bại)
                $(".add-to-cart .btn").removeClass("disabled");
            },
        });
    };

    init.triggerProductVariant = () => {
        let currentUrl = new URL(window.location.href);
        const attribute_id = currentUrl.searchParams.get("attribute_id");
        if (attribute_id) {
            init.handleAttribute();
        }
    };

    init.setUpVariantName = (response) => {
        let productName = $('input[name="product_name"]').val();
        let variantName = productName + " " + response?.languages[0].pivot.name;
        $(".product-main-title").html(variantName);
    };

    init.setUpVariantPrice = (response) => {
        let promotion = response?.promotion;

        if (!promotion) {
            return false;
        }

        $(".price-variant").html(promotion.priceHtml);
        $(".discount-wrap").html(promotion.discountHtml);
    };

    init.setUpVariantAlbum = (albums) => {
        let productName = $('input[name="product_name"]').val();
        if (albums.length <= 0) {
            return false;
        }

        const createThumbnail = (album) => `
            <div class="thumbnail">
                <a href="${album}" class="popup-zoom">
                    <img src="${album}" alt="${productName}">
                </a>
            </div>`;

        const createSmallThumb = (album) => `
            <div class="small-thumb-img">
                <img src="${album}" alt="${productName}">
            </div>`;

        const albumThumbnail = albums.map(createThumbnail).join("");
        const albumSmallThumb = albums.map(createSmallThumb).join("");

        const html = `
            <div class="row">
                <div class="col-lg-10 order-lg-2">
                    <div class="single-product-thumbnail-wrap zoom-gallery">
                        <div class="single-product-thumbnail product-large-thumbnail-3 axil-product">
                            ${albumThumbnail}
                        </div>
                        <div class="discount-wrap">
                            <div class="label-block">
                                <div class="product-badget">Giảm 20%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 order-lg-1">
                    <div class="product-small-thumb-3 small-thumb-wrapper">
                        ${albumSmallThumb}
                    </div>
                </div>
            </div>`;

        $(".product-album").html(html);
        setTimeout(function () {
            $(document).ready(function () {
                init.slickAblumActive();
                init.zoomGalleryActive();
            });
        });
    };

    $(document).ready(function () {
        init.slickActive();
        init.zoomGalleryActive();
        init.slickAblumActive();
        init.selectVariant();
        init.triggerProductVariant();
    });
});

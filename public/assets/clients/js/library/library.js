if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.modalProduct = () => {
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

    $(document).ready(function () {
        init.modalProduct();
    });
});

if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.slickActive = () => {
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

        $(".recent-product-activation").slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: true,
            dots: false,
            prevArrow:
                '<button class="slide-arrow prev-arrow"><i class="fal fa-long-arrow-left"></i></button>',
            nextArrow:
                '<button class="slide-arrow next-arrow"><i class="fal fa-long-arrow-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    },
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    },
                },
                {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    };

    $(document).ready(function () {
        init.slickActive();
    });
});

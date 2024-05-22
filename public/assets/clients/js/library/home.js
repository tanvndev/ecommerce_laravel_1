if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.slickOption = (setting) => {
        let option = {
            infinite: true,
        };
        option.autoplay = setting.autoplay == "active" ? true : false;
        option.speed = parseInt(
            setting?.animationSpeed?.replace(".", "") ?? 1000
        );

        option.focusOnSelect = setting?.pauseHover ? true : false;

        option.arrows = setting.arrow == "arrows" ? true : false;
        option.prevArrow =
            '<button class="slide-arrow prev-arrow"><i class="fal fa-long-arrow-left"></i></button>';
        option.nextArrow =
            '<button class="slide-arrow next-arrow"><i class="fal fa-long-arrow-right"></i></button>';

        option.dots = setting.navigate == "dots" ? true : false;

        return option;
    };

    init.slickSliderMain = () => {
        let setting = $(".axil-main-slider-area").data("setting");
        let option = init.slickOption(setting);
        let optionThumb = {
            ...option,
            slidesToShow: 2,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
            asNavFor: ".slider-content-activation-one",
        };

        $(".slider-thumb-activation-one").slick(optionThumb);

        $(".slider-content-activation-one").slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            focusOnSelect: false,
            speed: 500,
            fade: true,
            autoplay: false,
            asNavFor: ".slider-thumb-activation-one",
        });

        $(".categrie-product-activation").slick({
            infinite: true,
            slidesToShow: 7,
            slidesToScroll: 7,
            arrows: true,
            dots: false,
            autoplay: false,
            speed: 1000,
            prevArrow:
                '<button class="slide-arrow prev-arrow"><i class="fal fa-long-arrow-left"></i></button>',
            nextArrow:
                '<button class="slide-arrow next-arrow"><i class="fal fa-long-arrow-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 6,
                    },
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    },
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    },
                },
                {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    },
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    };

    init.slickFeedback = () => {
        $(".testimonial-slick-activation").slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            arrows: true,
            dots: false,
            speed: 1000,
            draggable: true,
            prevArrow:
                '<button class="slide-arrow prev-arrow"><i class="fal fa-long-arrow-left"></i></button>',
            nextArrow:
                '<button class="slide-arrow next-arrow"><i class="fal fa-long-arrow-right"></i></button>',
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });
    };

    init.slickArrivalProduct = () => {
        $(".new-arrivals-product-activation").slick({
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
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    };

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
        init.slickSliderMain();
        init.slickFeedback();
        init.slickArrivalProduct();
        // init.modalProduct();
    });
});

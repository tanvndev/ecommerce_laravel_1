if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.getLocation = () => {
        $(".locations").on("change", function () {
            let _this = $(this);
            // const location_id = ;

            let options = {
                data: {
                    location_id: _this.val(),
                },
                target: _this.attr("data-target"),
            };

            init.sendDataLocation(options);
        });
    };

    init.sendDataLocation = (options) => {
        const url = "/ajax/location/getLocation";
        $.ajax({
            url: url,
            dataType: "json",
            type: "get",

            data: options,
            success: function (response) {
                if (response.length > 0) {
                    $(`.${options.target}`).html(response);

                    if (district_id && options.target == "districts") {
                        $(".districts").val(district_id).trigger("change");
                    }

                    if (ward_id && options.target == "wards") {
                        $(".wards").val(ward_id).trigger("change");
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
        });
    };

    init.loadCity = () => {
        const province_id_1 = $(".provinces");
        const selectedValue = province_id_1.val();
        if (selectedValue) {
            province_id_1.trigger("change");
        }
    };

    $(document).ready(function () {
        init.getLocation();
        init.loadCity();
    });
});

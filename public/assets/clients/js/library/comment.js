if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

jQuery(function ($) {
    "use strict";
    var init = {};

    init.createComment = function () {
        $(document).on("submit", "#form-review", function (e) {
            e.preventDefault();
            let _this = $(this);
            let formData = _this.serialize();
            $.ajax({
                url: "/ajax/comment/store",
                type: "POST",
                data: formData,
                success: function (response) {
                    // Xử lý khi gửi thành công
                    if (response?.code == 200) {
                        setToast("success", response.message);
                        window.location.reload();
                        return true;
                    }

                    setToast("error", response.message);
                },
                error: function (xhr, status, error) {
                    // Xử lý khi có lỗi xảy ra
                    let errors = JSON.parse(xhr.responseText);
                    init.handleErrorComment(errors.errors);
                },
            });
        });
    };

    init.handleErrorComment = function (errors) {
        if (errors == "") {
            return;
        }
        for (const key in errors) {
            if (Object.hasOwnProperty.call(errors, key)) {
                const error = errors[key];
                let $formReview = $("#form-review").find(`[name="${key}"]`);
                $formReview.addClass("is-invalid");
                $formReview.siblings(".invalid-feedback").text(error[0]);
            }
        }
    };

    init.validateComment = function () {
        let $formReview = $("#form-review");
        let timerTyping;
        $formReview.find("input,textarea").on("keyup", function () {
            let _this = $(this);
            let errors;
            let error = [];
            let regex;
            let name = _this.attr("name");
            let validates = _this.data("validate");
            validates = validates.split("|");
            clearTimeout(timerTyping);

            timerTyping = setTimeout(() => {
                validates.forEach((validate) => {
                    switch (validate) {
                        case "required":
                            if (_this.val() == "") {
                                error.push("Thông tin bắt buộc nhập.");
                            }
                            break;
                        case "email":
                            // validate email
                            regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!regex.test(_this.val())) {
                                error.push("Email phải đúng định dạng.");
                            }
                            break;
                        case "phone":
                            regex = /^[0-9]{10}$/;
                            if (!regex.test(_this.val())) {
                                error.push(
                                    "Số điện thoại phải đúng định dạng."
                                );
                            }
                        default:
                            break;
                    }
                });
                errors = {
                    [name]: error,
                };

                if (error && error.length > 0) {
                    return init.handleErrorComment(errors);
                }

                _this.removeClass("is-invalid");
            }, 500);
        });
    };

    $(document).ready(function () {
        init.createComment();
        init.validateComment();
    });
});

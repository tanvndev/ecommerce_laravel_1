if (typeof jQuery === "undefined") {
    throw new Error("jQuery plugins need to be before this file");
}

$(function () {
    "use strict";
    var init = {};
    var _token = $('meta[name="csrf-token"]').attr("content");

    // Init select2
    init.initSelect2 = () => {
        if ($(".init-select2").length > 0) {
            $(".init-select2").each((index, element) => {
                $(element).select2();
            });
        }
    };

    // Hàm này sử dụng khi lọc sẽ tự động submit
    init.filter = () => {
        if ($(".filter").length > 0) {
            $(".filter").on("change", function () {
                setTimeout(() => {
                    // phương thức closest() được sử dụng để tìm phần tử cha gần nhất của một phần tử được chọn
                    $(this).closest("form").submit();
                }, 500);
            });
        }
    };

    // Hàm này giúp thêm id vào form xoá
    init.modalDelete = () => {
        if ($(".btn-delete").length > 0) {
            $(".btn-delete").on("click", function () {
                const _id = $(this).data("id");
                if (!_id) {
                    return setToast("error", "Có lỗi vui lòng thử lại.");
                }
                $("#_id").val(_id);
            });
        }
    };

    init.changeStatus = () => {
        if ($(".status").length > 0) {
            $(".status").on("change", function () {
                const _this = $(this);
                let options = {
                    modelId: _this.data("modelid"),
                    value: _this.val(),
                    model: _this.data("model"),
                    field: _this.data("field"),
                };

                const url = "/ajax/dashboard/changeStatus";
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: "post",
                    // Với method post thì phải gửi thêm _token
                    headers: {
                        "X-CSRF-TOKEN": _token,
                    },
                    data: options,
                    success: function (response) {
                        handleToast(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    },
                });
            });
        }
    };

    init.checkAll = () => {
        if ($("#check-all").length > 0) {
            $("#check-all").on("change", function () {
                const isChecked = $(this).prop("checked");

                // prop() là một phương thức được sử dụng để thiết lập hoặc trả về giá trị của thuộc tính của một phần tử DOM - $(selector).prop(propertyName, value)
                $(".check-item").prop("checked", isChecked);
            });
        }
    };

    init.checkItem = () => {
        if ($(".check-item").length > 0) {
            $(".check-item").on("click", function () {
                // Kiểm tra số lượng checkbox đã chọn
                var totalChecked = $(".check-item:checked").length;
                var totalCheckboxes = $(".check-item").length;

                // Kiểm tra nếu tất cả các checkbox đã được chọn, thì chọn checkbox "checkAll", ngược lại thì bỏ chọn
                $("#check-all").prop(
                    "checked",
                    totalChecked === totalCheckboxes
                );
            });
        }
    };

    init.changeStatusAll = () => {
        if ($(".change-status-all").length > 0) {
            $(".change-status-all").click(function (e) {
                let id = [];
                const _this = $(this);
                e.preventDefault();

                // Lấy ra toàn bộ các id của checked
                $(".check-item:checked").each(function () {
                    id.push($(this).val());
                });

                if (id.length <= 0) {
                    return setToast("warning", "Có lỗi vui lòng thử lại.");
                }

                let options = {
                    id: id,
                    value: _this.data("value"),
                    model: _this.data("model"),
                    field: _this.data("field"),
                };

                const url = "/ajax/dashboard/changeStatusAll";
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: "post",
                    // Với method post thì phải gửi thêm _token
                    headers: {
                        "X-CSRF-TOKEN": _token,
                    },
                    data: options,
                    success: function (response) {
                        const checked = options.value == 1; // true nếu value là 1, ngược lại là false

                        for (const id of options.id) {
                            $(`#publish-${id}`).prop("checked", checked);
                        }

                        handleToast(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    },
                });
            });
        }
    };

    $(document).ready(function () {
        init.filter();
        init.modalDelete();
        init.initSelect2();
        init.changeStatus();
        init.checkAll();
        init.checkItem();
        init.changeStatusAll();
    });
});

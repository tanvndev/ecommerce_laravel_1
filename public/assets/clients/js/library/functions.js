// Khởi tạo Toast
var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    },
});

const formatToCommas = (nStr) => {
    nStr = String(nStr);
    nStr = nStr.replace(/\./gi, "");
    let str = "";
    for (let i = nStr.length; i > 0; i -= 3) {
        let a = i - 3 < 0 ? 0 : i - 3;
        str = nStr.slice(a, i) + "." + str;
    }
    str = str.slice(0, str.length - 1);
    return str;
};

const formatCommasToNumber = (str) => {
    // Loại bỏ dấu phẩy trong chuỗi
    let numberString = str.replace(/\./g, "");
    // Chuyển chuỗi thành số nguyên
    let number = parseInt(numberString, 10);
    return number;
};

// Hàm này Chạy thông báo Toast
const setToast = (icon, title) => {
    Toast.fire({
        icon,
        title,
    });
};

const setAlertBasic = (icon, title) => {
    Swal.fire({
        icon,
        title,
    });
};

// Hàm này sử lý thông báo
const handleToast = (response) => {
    if (Object.keys(response).length <= 0) {
        return setToast("error", "Có lỗi vui lòng thử lại.");
    }

    if (response.status == 1) {
        return setToast("success", response.message);
    }

    if (response.status == 0) {
        return setToast("error", response.message);
    }
};

const formatCurrency = (amount, currencyCode = "vn") => {
    switch (currencyCode.toUpperCase()) {
        case "VN":
            // Format for Vietnamese currency (VND)
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND",
                minimumFractionDigits: 0,
            }).format(amount);
        case "CN":
            // Format for Chinese currency (CNY)
            return new Intl.NumberFormat("zh-CN", {
                style: "currency",
                currency: "CNY",
            }).format(amount);
        case "EN":
            // Format for US currency (USD)
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            }).format(amount);
        default:
            // If the currency code is not supported, return the original amount
            return amount.toString();
    }
};

const convertToSlug = (str) => {
    str = str.toLowerCase(); // chuyen ve ki tu biet thuong
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(
        /!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'|\–| |\"|\&|\#|\[|\]|\\|\/|~|$|_/g,
        "-"
    );
    str = str.replace(/-+-/g, "-");
    str = str.replace(/^\-+|\-+$/g, "");
    return str;
};

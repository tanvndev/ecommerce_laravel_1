<!DOCTYPE html>

<head>
    <title>Đặt hàng thành công</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            text-align: center;
            margin: 0 auto;
            width: 800px;
            font-family: "Montserrat", sans-serif;
            background-color: #e2e2e2;
            display: block;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        p {
            margin: 15px 0;
        }

        h5 {
            color: #444;
            text-align: left;
            font-weight: 400;
        }

        .text-center {
            text-align: center
        }

        .title {
            color: #444444;
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0;
            padding-bottom: 0;
            text-transform: uppercase;
            display: inline-block;
            line-height: 1;
        }

        table {
            margin-top: 30px
        }

        table.top-0 {
            margin-top: 0;
        }

        table.order-detail {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        table.order-detail tr:nth-child(even) {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        table.order-detail tr:nth-child(odd) {
            border-bottom: 1px solid #ddd;
        }

        .order-detail th {
            font-size: 16px;
            padding: 15px;
            background: #eff2f7;
        }

        .pad-left-right-space {
            border: unset !important;
        }

        .pad-left-right-space td {
            padding: 5px 15px;
        }

        .pad-left-right-space td p {
            margin: 0;
        }

        .pad-left-right-space td b {
            font-size: 15px;
            font-family: 'Rubik', sans-serif;
        }

        .main-bg-light {
            background-color: #3d3d3d;
            color: #fff;
        }

        .footer-social-icon tr td {
            width: 30px;
            height: 30px;
            background: transparent;
            margin: 0 30px;
            border-radius: 50%;
            text-align: center;
        }

        .footer-social-icon tr td a {
            width: 100%;
            align-items: center;
            display: flex;
            justify-content: center;
            color: #fff;
        }

        .footer-social-icon tr td a i {
            width: 50%;
            margin: 0;
        }

        .footer-subscript p {
            margin: 0;
            letter-spacing: 1.1px;
            line-height: 1.6;
            font-size: 14px;
        }

        .footer-subscript p a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>

{{-- @dd($order) --}}

<body style="margin: 20px auto; width: 800px; background-color: #e2e2e2;
display: block;">
    <table align="center" border="0" cellpadding="0" cellspacing="0"
        style="padding: 0 30px;background-color: #fff; box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 100%;-webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);">
        <tbody>
            <tr>
                <td>
                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;"
                        width="100%">
                        <tr>
                            <td style="text-align: center;">
                                <img src="https://res.cloudinary.com/dfgkkkcoc/image/upload/v1717147830/others/vlzmwkxtyafk5s4axtsi.jpg"
                                    alt="" style="margin-bottom: 30px; width: 70%;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size: 14px;"><b>Xin chào {{$order['fullname']}},</b></p>
                                <p style="font-size: 14px;">Đơn hàng đã được xử lý thành công và đơn hàng của bạn đang
                                    được gửi đi,</p>
                                <p style="font-size: 14px;">Mã đơn hàng: <b>{{$order['code']}},</b></p>
                                <p style="font-size: 14px;">Ngày đặt hàng: <b>{{ convertDateTime($order['created_at'],
                                        'H:i
                                        - d/m/Y') }},{{ convertDateTime($order['created_at'], 'H:i
                                        - d/m/Y') }},</b></p>
                                <p style="font-size: 14px;">Số điện thoại: <b>{{$order['phone']}},</b></p>
                                <p style="font-size: 14px;">Phương thức thanh toán: <b>{{
                                        array_column(__('payment.method'), 'title', 'name')[$order['payment_method']]
                                        }},</b>
                                </p>
                                <p style="font-size: 14px;">Tổng:
                                    <b> {{ formatCurrency($order['cart']['total'] ?? 0) }},</b>
                                </p>

                            </td>
                        </tr>
                    </table>

                    <table cellpadding="0" cellspacing="0" border="0" align="left"
                        style="width: 100%;margin-top: 10px;margin-bottom: 10px;">
                        <tbody>
                            <tr>
                                <td style="background-color: #eff2f7;padding: 15px;letter-spacing: 0.3px;width: 50%;">
                                    <h5
                                        style="font-size: 16px; font-weight: 600;color: #000; line-height: 16px; padding-bottom: 13px; border-bottom: 1px solid #ddd; letter-spacing: -0.65px; margin-top:0; margin-bottom: 13px;">
                                        Địa chỉ giao hàng của bạn</h5>
                                    <p
                                        style="text-align: left;font-weight: normal; font-size: 14px; color: #000000;line-height: 21px;margin-top: 0;">
                                        {{$order['address']}}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="left"
                        style="width: 100%;    margin-bottom: 50px;">
                        <tr align="left">
                            <th width="30%">SẢN PHẨM</th>
                            <th>SỐ LƯỢNG</th>
                            <th>GIÁ BÁN </th>
                            <th>THÀNH TIỀN </th>
                        </tr>

                        @foreach ($order['cart']['detail'] as $item)
                        <tr>
                            <td valign="top" style="padding-left: 15px;">
                                <h5 style="font-size: 14px; color:#444;margin-top: 10px;">{{$item->name}} </h5>
                            </td>
                            <td valign="top" style="padding-left: 15px;">
                                <h5 style="font-size: 14px; color:#444;margin-top: 10px;"><b>x{{$item->qty}}</b></h5>
                            </td>
                            <td valign="top" style="padding-left: 15px;">
                                <h5 style="font-size: 14px; color:#444;margin-top:15px">
                                    <b>{{formatCurrency($item->price)}}</b>
                                </h5>
                            </td>
                            <td valign="top" style="padding-left: 15px;">
                                <h5 style="font-size: 14px; color:#444;margin-top:15px"><b>{{formatCurrency($item->price
                                        * $item->qty)}}</b></h5>
                            </td>
                        </tr>
                        @endforeach

                        <tr class="pad-left-right-space ">
                            <td class="m-t-5" colspan="2" align="left">
                                <p style="font-size: 14px;">Tạm tính : </p>
                            </td>
                            <td class="m-t-5" colspan="2" align="right">
                                <b style>{{ formatCurrency($order['cart']['total'] ?? 0) }}</b>
                            </td>
                        <tr class="pad-left-right-space">
                            <td colspan="2" align="left">
                                <p style="font-size: 14px;">Giảm giá:</p>
                            </td>
                            <td colspan="2" align="right">
                                <b>- {{formatCurrency($order['promotion']['discount'])}}</b>
                            </td>
                        </tr>

                        <tr class="pad-left-right-space">
                            <td colspan="2" align="left">
                                <p style="font-size: 14px;">Phí vận chuyển:</p>
                            </td>
                            <td colspan="2" align="right">
                                <b>Miễn phí</b>
                            </td>
                        </tr>

                        <tr class="pad-left-right-space ">
                            <td class="m-b-5" colspan="2" align="left">
                                <p style="font-size: 14px;">Tổng :</p>
                            </td>
                            <td class="m-b-5" colspan="2" align="right">
                                <b>{{formatCurrency($order['cart']['total'] - $order['promotion']['discount'])}}</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="main-bg-light text-center" style="margin-top: 0;" align="center" border="0" cellpadding="0"
        cellspacing="0" width="100%">
        <tr>
            <td style="padding: 30px;">
                <div>
                    <h4 class="title" style="margin:0;text-align: center; color: whitesmoke;">Follow us
                    </h4>
                </div>
                <table border="0" cellpadding="0" cellspacing="0" class="footer-social-icon text-center" align="center"
                    style="margin-top:20px;">
                    <tr>
                        <td>
                            <a href="javascript:void(0)">
                                <img src="https://res.cloudinary.com/dfgkkkcoc/image/upload/v1717148092/others/rrbjzq8hjihllxi6gedg.png"
                                    alt="" style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);">
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0)">
                                <img src="https://res.cloudinary.com/dfgkkkcoc/image/upload/v1717148092/others/ao8gvtxre3xgcc0rxznz.png"
                                    alt="" style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);">
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0)">
                                <img src="https://res.cloudinary.com/dfgkkkcoc/image/upload/v1717148091/others/iokfiojbym6ovajwdcu1.png"
                                    alt="" style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);">
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0)">
                                <img src="https://res.cloudinary.com/dfgkkkcoc/image/upload/v1717148090/others/zfguu76d7ewtmxspbs3w.png"
                                    alt="" style="font-size: 25px; width: 22px;filter: invert(1);">
                            </a>
                        </td>
                    </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 20px auto 0;"
                    class="footer-subscript">
                    <tr>
                        <td>
                            <p>
                                Cảm ơn quý khách đã đặt hàng. Đơn hàng của quý khách đã được xác nhận
                                và đang trong quá trình xử lý. Chúng tôi sẽ thông báo ngay khi đơn hàng được gửi đi. Nếu
                                có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
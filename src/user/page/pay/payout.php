<?php
require_css("./src/user/css/pay/payout.css");
global $api;

date_default_timezone_set("Asia/Bangkok");

$us_info = $api->get_user_info();
$us_id = $us_info["us_id"];
$us_name = $us_info["us_name"];
$us_address = $us_info["us_address"];
$us_number_phone = $us_info["us_number_phone"];

$method_info = $_POST["method_info"] ?? "default";

if ($method_info == "new") {
    $us_name = "";
    $us_address = "";
    $us_number_phone = "";
}

if (isset($_POST["action"])) {
    $od_created_on = date("Y-m-d H:i:s");
    $od_delivery_time = str_replace("T", " ", $_POST["delivery_time"]);
    $od_person_receive = $_POST["name"];
    $od_address = $_POST["address"];
    $od_number_phone = $_POST["phone"];
    $od_price = $_POST["total"];
    $od_id = hash("crc32", "$us_id $od_created_on");

    $order = [
        "od_id" => $od_id,
        "od_created_on" => $od_created_on,
        "od_delivery_time" => $od_delivery_time,
        "od_person_receive" => $od_person_receive,
        "od_address" => $od_address,
        "od_number_phone" => $od_number_phone,
        "od_price" => $od_price
    ];

    $result = $api->create_order($us_id, $order);

    if ($result["success"]) {
        $api->clear_cart($us_id);
        set_toast_message($result["message"]);
        redirect("?direct=history");
    } else {
        toast($result["message"]);
    }
}

$minDateTime = date("Y-m-d\TH:i", strtotime("+1 day"));
$cart = $api->get_cart_products($us_id);
$total = 0;
?>

<div class="layout-container">
    <div class="payout-container">
        <p class="title">Thông tin thanh toán</p>

        <form class="horizontal-container" method="post" onchange="this.submit()">
            <div class="choice">
                <input type="radio" name="method_info" <?=
                    $method_info == "default" ? "checked" : ""
                    ?> value="default">
                <p>Sử dụng thông tin mặc định</p>
            </div>

            <div class="choice">
                <input type="radio" name="method_info" <?=
                    $method_info == "new" ? "checked" : ""
                    ?> value="new">
                <p>Điền mới</p>
            </div>
        </form>

        <form method="post">

            <div class="input-group">
                <p>Họ và tên:</p>
                <input type="text" name="name" placeholder="Nhập tên" minlength="3" maxlength="50" required
                    value="<?= $us_name ?>" <?= $method_info == "default" ? "readonly" : "" ?>>
            </div>

            <div class="input-group">
                <p>Địa chỉ:</p>
                <input type="text" name="address" placeholder="Nhập địa chỉ" minlength="3" required
                    value="<?= $us_address ?>" <?= $method_info == "default" ? "readonly" : "" ?>>
            </div>

            <div class="input-group">
                <p>Số điện thoại:</p>
                <input type="tel" name="phone" pattern="[0-9]{10}" maxlength="10" placeholder="Nhập số điện thoại"
                    required value="<?= $us_number_phone ?>" <?= $method_info == "default" ? "readonly" : "" ?>>
            </div>

            <div class="input-group">
                <p>Chọn ngày giao:</p>
                <input type="datetime-local" name="delivery_time" min="<?= $minDateTime ?>" required>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th class="col-1">Tên sản phẩm</th>
                        <th class="col-2">Số lượng</th>
                        <th class="col-3">Tổng cộng</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cart as $product) {
                        $combinedPrice = $product["pd_price"] * $product["ca_quantity"];
                        $total += $combinedPrice; ?>
                        <tr>
                            <td class="col-1"><?= $product["pd_name"] ?></td>

                            <td class="col-2"><?= $product["ca_quantity"] ?></td>

                            <td class="col-3">
                                <?= convert_currency($combinedPrice) ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="total-section">
                <p class="total-title">Thành tiền:</p>
                <p class="total-text"><?= convert_currency($total) ?></p>
            </div>

            <input type="hidden" name="action" value="payout">
            <input type="hidden" name="total" value="<?= $total ?>">
            <input type="submit" class="btn" value="Xác nhận thanh toán">

        </form>
    </div>
</div>
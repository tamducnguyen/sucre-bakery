<?php
require_css("./src/user/css/account/modify.css");
global $api;

$us_info = $api->get_user_info();
$us_id = $us_info['us_id'];
$us_name = $us_info['us_name'];
$us_number_phone = $us_info['us_number_phone'];
$us_password = $us_info['us_password'];
$us_address = $us_info['us_address'];

if (isset($_POST['name']) || isset($_POST['address']) || isset($_POST['phone'])) {
    $new_name = $_POST['name'];
    $new_number_phone = $_POST['phone'];
    $new_password = $_POST['password'];
    $new_address = $_POST['address'];

    $user = [];

    if ($new_name != $us_name) {
        $user["us_name"] = $new_name;
    }

    if ($new_number_phone != $us_number_phone) {
        $user["us_number_phone"] = $new_number_phone;
    }

    if ($new_password != $us_password) {
        $user["us_password"] = $new_password;
    }

    if ($new_address != $us_address) {
        $user["us_address"] = $new_address;
    }

    $result = $api->edit_user($us_id, $user);

    if ($result["success"]) {
        set_toast_message($result["message"]);
    } else {
        toast($result["message"]);
    }
    redirect("?direct=modify");
}
?>

<div class="layout-container">
    <div class="modify-container">
    <p class="modify-title">Sửa thông tin</p>
        <form method="post">

            <div class="input-group">
                <label for="name">Tên:</label>
                <input type="text" id="name" name="name" placeholder="Nhập tên" minlength="3" maxlength="50"
                    value="<?= $us_name ?>">
            </div>

            <div class="input-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" maxlength="10"
                    placeholder="Nhập số điện thoại" value="<?= $us_number_phone ?>">
            </div>

            <div class="input-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" minlength="3"
                    maxlength="50" value="<?= $us_password ?>">
            </div>

            <div class="input-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" placeholder="Nhập địa chỉ" minlength="3"
                    maxlength="50" value="<?= $us_address ?>">
            </div>

            <input type="submit" class="btn" value="Cập nhật">
        </form>
    </div>
</div>
<?php
require_css("./src/user/css/account/register.css");
global $api;

if (isset($_POST["username"]) && isset($_POST["phone"]) && isset($_POST["password"])) {
    $us_name = $_POST["username"];
    $us_number_phone = $_POST["phone"];
    $us_password = $_POST["password"];

    $result = $api->register_user($us_name, $us_number_phone, $us_password);

    if ($result["success"]) {
        set_toast_message($result["message"]);
        redirect("?direct=login");
    } else {
        toast($result["message"]);
    }
}
?>

<div class="layout-container">
    <div class="register-container">
        <h2>Đăng ký</h2>
        <form method="post">
            <div class="input-group">
                <label for="username">Tên:</label>
                <input type="text" id="username" name="username" placeholder="Nhập tên" minlength="3" , maxlength="50"
                    required>
            </div>

            <div class="input-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" maxlength="10"
                    placeholder="Nhập số điện thoại" required>
            </div>

            <div class="input-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" minlength="3"
                    maxlength="50" required>
            </div>

            <input type="submit" class="btn" value="Đăng ký">

            <div class="login">
                <p>Đã có tài khoản? <a href="?direct=login">Đăng nhập ngay</a></p>
            </div>
        </form>
    </div>
</div>
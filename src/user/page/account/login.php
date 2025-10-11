<?php
require_css("./src/user/css/account/login.css");
global $api;

if (isset($_POST["phone"]) && isset($_POST["password"])) {
    $us_number_phone = $_POST["phone"];
    $us_password = $_POST["password"];

    $result = $api->login_user($us_number_phone, $us_password);

    if ($result["success"]) {
        set_toast_message($result["message"]);
        redirect("?direct=home");
    } else {
        toast($result["message"]);
    }
}
?>

<div class="layout-container">
    <div class="login-container">
        <h2>Đăng Nhập</h2>
        <form method="post">
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

            <input type="submit" class="btn" value="Đăng nhập">

            <div class="register">
                <p>Chưa có tài khoản? <a href="?direct=register">Đăng ký ngay.</a></p>
            </div>
        </form>
    </div>
</div>
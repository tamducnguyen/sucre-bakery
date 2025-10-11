<?php
require_css("./src/admin/css/login.css");
global $api;

if (isset($_POST["ad_name"]) && isset($_POST["ad_password"])) {
    $ad_name = $_POST["ad_name"];
    $ad_password = $_POST["ad_password"];

    $result = $api->login_admin($ad_name, $ad_password);

    if ($result["success"]) {
        set_toast_message($result["message"]);
        redirect("?direct=home");
    } else {
        toast($result["message"]);
    }
}
?>

<div class="layout-container">
    <div class="panel">
        <p class="title">Đăng nhập quản trị viên</p>

        <form class="form" method="post">
            <label class="label">Tên</label>
            <input class="input" type="text" name="ad_name" placeholder="Nhập tên quản trị" required>

            <label class="label">Mật khẩu</label>
            <input class="input" type="password" name="ad_password" placeholder="Nhập mật khẩu" required>

            <input class="button" type="submit" value="Đăng nhập">
        </form>
    </div>
</div>
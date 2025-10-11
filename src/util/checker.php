<?php
function authorize_user()
{
    if (!isset($_SESSION["us_info"])) {
        set_toast_message("Bạn chưa đăng nhập!");
        redirect("?direct=login");
    }
}

function authorize_admin()
{
    if (!isset($_SESSION["ad_info"])) {
        set_toast_message("Bạn chưa đăng nhập!");
        redirect("?direct=login");
    }
}

function block_login_user()
{
    if (isset($_SESSION["us_info"])) {
        set_toast_message("Bạn đã đăng nhập!");
        redirect("?direct=login");
    }
}

function block_login_admin()
{
    if (isset($_SESSION["ad_info"])) {
        set_toast_message("Bạn đã đăng nhập!");
        redirect("?direct=login");
    }
}
<?php
require_css("./src/admin/css/home.css");
global $api;

$ad_info = $api->get_admin_info();
$ad_name = $ad_info["ad_name"];
?>

<div class="greeting">
    <p class="title">Mỗi ngày làm việc là một niềm vui.</p>
    <p class="name">Chào mừng <?= $ad_name ?>. Quay lại làm việc thôi nào!</p>
</div>

<div class="thumbnail">
    <img class="image" src="./public/img/thumbnail.jpeg">
    <div class="time">
        <p class="day"><?= date("d") ?></p>
        <p class="month"><?= "Tháng " . date("m") ?></p>
    </div>
</div>
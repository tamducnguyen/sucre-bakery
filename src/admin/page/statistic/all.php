<?php
require_css("./src/admin/css/statistic/all.css");
global $api;

$waitNumber = $api->get_order_count_by_status(1);
$workNumber = $api->get_order_count_by_status(2);
$doneNumber = $api->get_order_count_by_status(3);
$cancelNumber = $api->get_order_count_by_status(4);
?>

<p class="title">Thống kê</p>

<div class="container">
    <div class="item">
        <p class="title">Đơn chờ tiếp nhận</p>

        <p class="number"><?= $waitNumber ?></p>
    </div>

    <div class="item">
        <p class="title">Đơn đang làm</p>

        <p class="number"><?= $workNumber ?></p>
    </div>

    <div class="item">
        <p class="title">Đơn đã giao</p>

        <p class="number"><?= $doneNumber ?></p>
    </div>

    <div class="item">
        <p class="title">Đơn đã hủy</p>

        <p class="number"><?= $cancelNumber ?></p>
    </div>
</div>
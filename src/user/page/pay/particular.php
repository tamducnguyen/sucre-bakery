<?php
require_css("./src/user/css/pay/particular.css");
global $api;

$od_id = $_GET["od_id"];

$us_info = $api->get_user_info();
$us_id = $us_info["us_id"];

$order = $api->get_order_info($od_id);
?>

<div class="layout-container">
    <div class="particular-container">
        <h2 class="particular-title">Chi Tiết Đơn Hàng</h2>
        <p><strong>Mã đơn hàng: </strong> <?= $order["od_id"] ?></p>

        <p><strong>Ngày đặt: </strong><?= convert_datetime($order["od_created_on"]) ?></p>

        <p><strong>Ngày Giao: </strong><?= convert_datetime($order["od_delivery_time"]) ?></p>

        <p><strong>Người nhận: </strong><?= $order["od_person_receive"] ?></p>

        <p><strong>Địa chỉ: </strong><?= $order["od_address"] ?></p>

        <p><strong>SĐT: </strong><?= $order["od_number_phone"] ?></p>

        <h3>Danh sách sản phẩm:</h3>
        <table class="products-table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $order_total = 0;
                $order_products = $api->get_order_products_info($order["od_id"]);
                foreach ($order_products as $product):
                    $combinedPrice = $product["pod_price"] * $product["pod_quantity"];
                    $order_total += $combinedPrice; ?>
                    <tr>
                        <td><?= $product["pod_name"] ?></td>
                        <td><?= $product["pod_quantity"] ?></td>
                        <td><?= convert_currency($combinedPrice) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Tổng tiền: </strong><?= convert_currency($order_total) ?></p>

        <p><strong>Tình trạng: </strong><?= $order["os_name"] ?></p>

    </div>
</div>
<?php
require_css("./src/user/css/pay/history.css");
global $api;

$us_info = $api->get_user_info();
$us_id = $us_info["us_id"];

$orders = $api->get_history_order($us_id);
?>

<div class="layout-container">
    <div class="history-container">
        <p class="history-title">Lịch Sử Mua Hàng</p>

        <?php if (empty($orders)) { ?>
            <p class="no-history">Bạn chưa có đơn hàng nào!</p>
        <?php } else { ?>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Ngày Đặt Hàng</th>
                        <th>Ngày Giao Hàng</th>
                        <th>Tình Trạng</th>
                        <th>Thông Tin Đơn Hàng</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order["od_id"] ?></td>
                            <td><?= convert_datetime($order["od_created_on"]) ?></td>
                            <td><?= convert_datetime($order["od_delivery_time"]) ?></td>
                            <td><?= $order["os_name"] ?></td>
                            <td>
                                <a class="infor-btn" href="?direct=particular&od_id=<?php echo $order["od_id"]; ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        <?php } ?>
    </div>
</div>
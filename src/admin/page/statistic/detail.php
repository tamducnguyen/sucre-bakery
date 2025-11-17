<?php
require_css("./src/admin/css/statistic/detail.css");
global $api;

$ad_info = $api->get_admin_info();
$ad_id = $ad_info["ad_id"];

$od_id = $_GET["od_id"];
$order = $api->get_order_info($od_id);

if (isset($_POST["os_id"])) {
    $os_id = $_POST["os_id"];
    $api->update_order_status($od_id, $os_id);
    $api->update_checker($od_id, $ad_id);
    redirect("?direct=detail&od_id=$od_id");
}
?>

<p class="title">Chi tiết đơn hàng</p>

<div class="container">
    <div class="info">
        <div class="item">
            <p class="label">Mã đơn hàng: </p>
            <p class="text"><?= $order["od_id"] ?></p>
        </div>

        <div class="item">
            <p class="label">Ngày đặt: </p>
            <p class="text"><?= convert_datetime($order["od_created_on"]) ?></p>
        </div>

        <div class="item">
            <p class="label">Ngày giao: </p>
            <p class="text"><?= convert_datetime($order["od_delivery_time"]) ?></p>
        </div>

        <div class="item">
            <p class="label">Người đặt: </p>
            <p class="text"><?= $order["us_name"] ?></p>
        </div>

        <div class="item">
            <p class="label">Người nhận: </p>
            <p class="text"><?= $order["od_person_receive"] ?></p>
        </div>

        <div class="item">
            <p class="label">Địa chỉ: </p>
            <p class="text"><?= $order["od_address"] ?></p>
        </div>

        <div class="item">
            <p class="label">Số điện thoại: </p>
            <p class="text"><?= $order["od_number_phone"] ?></p>
        </div>
    </div>

    <div class="product">
        <div class="product-part">
            <p class="label">Danh sách sản phẩm:</p>

            <?php
            $order_total = 0;
            $order_products = $api->get_order_products_info($od_id);
            foreach ($order_products as $product) {
                $order_total += $product["pod_price"] * $product["pod_quantity"]; ?>
                <p class="detail">
                    <?= $product["pod_name"] . "&emsp;× " . $product["pod_quantity"] ?>
                </p>
            <?php } ?>
        </div>

        <div class="product-part">
            <p class="label">Thành tiền:</p>

            <p class="total"><?= convert_currency($order_total) ?></p>
        </div>

        <div class="product-part">
            <p class="label">Trạng thái:</p>

            <form method="post">
                <select class="status" name="os_id">
                    <?php
                    $currentOrderStatus = $api->get_order_status($od_id)["os_id"];
                    $orderStatuses = $api->get_order_statuses();

                    foreach ($orderStatuses as $orderStatus) {
                        $orderStatusId = $orderStatus["os_id"];
                        $orderStatusName = $orderStatus["os_name"]; ?>

                        <option value="<?= $orderStatusId ?>" <?= $currentOrderStatus == $orderStatusId ? "selected" : "" ?>>
                            <?= $orderStatusName ?>
                        </option>
                    <?php } ?>
                </select>

                <button class="submit-button" type="submit">Cập nhật</button>
            </form>

            <p class="checker">
                Người thao tác cuối:
                <?php
                $isCheck = $order["ad_id"];
                if ($isCheck) {
                    $checker = $api->get_checker($order["od_id"]);
                    echo $checker["ad_name"];
                } else {
                    echo "...";
                }
                ?>
            </p>
        </div>
    </div>
</div>
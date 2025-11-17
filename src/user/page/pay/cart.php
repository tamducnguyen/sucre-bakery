<?php
require_css("./src/user/css/pay/cart.css");
global $api;

$us_info = $api->get_user_info();
$us_id = $us_info["us_id"];

if (isset($_POST["action"])) {
    $pd_id = $_POST["pd_id"];

    switch ($_POST["action"]) {
        case "add":
            if ($api->exist_cart_product($us_id, $pd_id)) {
                $product = $api->get_cart_product($us_id, $pd_id);
                $api->update_cart_product($us_id, $pd_id, $product["ca_quantity"] + 1);
            } else {
                $api->add_cart_product($us_id, $pd_id);
            }
            break;

        case "remove":
            $api->remove_cart_product($us_id, $pd_id);
            break;

        case "update":
            $ca_quantity = $_POST["ca_quantity"];
            $api->update_cart_product($us_id, $pd_id, $ca_quantity);
            break;
    }
    redirect("?direct=cart");
}

$cart = $api->get_cart_products($us_id);
$total = 0;
?>

<div class="layout-container">
    <?php
    if (empty($cart)) { ?>
        <p class="no-product">Bạn chưa thêm gì vào giỏ hàng!</p>
    <?php } else { ?>
        <div class="cart-container">
            <p class="cart-title">Giỏ hàng</p>

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng cộng</th>
                        <th>Xoá</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($cart as $product) {
                        $combinedPrice = $product["pd_price"] * $product["ca_quantity"];
                        $total += $combinedPrice; ?>

                        <tr>
                            <td><img class="product-image" src=<?php load_image($product["pd_image"]); ?>></td>
                            <td><?= $product["pd_name"] ?></td>
                            <td><?= convert_currency($product["pd_price"]) ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="pd_id" value="<?php echo $product["pd_id"]; ?>">
                                    <input type="number" min="1" onchange="this.form.submit()" name="ca_quantity"
                                        value="<?php echo $product["ca_quantity"]; ?>">
                                </form>
                            </td>
                            <td><?= convert_currency($combinedPrice) ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="pd_id" value="<?php echo $product["pd_id"]; ?>">
                                    <input class="delete-btn" type="submit" value="Xoá">
                                </form>
                            </td>
                        <tr>
                        <?php } ?>
                </tbody>
            </table>

            <div class="cart-total-container">
                <p class="cart-total-title">Thành tiền:</p>
                <p class="cart-total"><?= convert_currency($total) ?></p>
            </div>
        </div>

        <div class="payout-direct">
            <a class="payout-btn" href="?direct=payout">Thanh toán</a>
        </div>
    <?php } ?>
</div>
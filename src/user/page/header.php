<?php
require_css("./src/user/css/header.css");
global $api;

$us_info = $api->get_user_info();
$link_class = $us_info ? "header-name" : "header-option";
$href = $us_info ? "?direct=modify" : "?direct=login";
$link_text = $us_info ? $us_info["us_name"] : "Đăng nhập";
?>

<header>
    <a class="header-logo" href="?direct=home">SUCRÉ BAKERY</a>

    <div class="header-navigation">
        <a class="header-option" href="?direct=search">Tìm kiếm</a>

        <a class="header-option" href="?direct=product">Sản phẩm</a>

        <a class="<?= $link_class ?>" href="<?= $href ?>">
            <?= $link_text ?>
        </a>

        <?php
        if ($us_info) { ?>
            <a class="header-option" href="?direct=history">Lịch sử mua hàng</a>
            
            <a class="header-option" href="?direct=logout">Đăng xuất</a>

            <a class="header-cart" href="?direct=cart">
                <p>Giỏ hàng</p>

                <?php
                $total_quantity = $api->get_cart_total_quantity($us_info["us_id"]);
                if ($total_quantity > 0) { ?>
                    <div class="header-cart-total"><?= $total_quantity ?></div>
                <?php } ?>
            </a>
        <?php } ?>
    </div>
</header>
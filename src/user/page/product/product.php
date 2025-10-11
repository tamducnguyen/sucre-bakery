<?php
require_css("./src/user/css/product/product.css");
global $api;

$pdt_id = $_GET["pdt_id"] ?? 1;
$products = $api->get_products_by_type($pdt_id);
$productTypes = $api->get_product_types();
$currentProductType = $api->get_product_type_by_id($pdt_id);
?>

<div class="layout-container">
    <div class="menu">
        <div class="menu-left">
            <p class="title">Loại sản phẩm</p>
            <?php
            foreach ($productTypes as $productType) { ?>
                <a class="product-type"
                    href="?direct=product&pdt_id=<?php echo $productType["pdt_id"]; ?>"><?php echo $productType["pdt_name"]; ?></a>
            <?php } ?>
        </div>

        <?php
        if (empty($products)) { ?>
            <p class="no-product">Không có dữ liệu</p>
        <?php } else { ?>
            <div class="menu-main">
                <p class="title"><?php echo $currentProductType["pdt_name"]; ?></p>
                <div class="menu-result">
                    <?php
                    foreach ($products as $product) { ?>
                        <div class="product-item">
                            <img class="product-image" src=<?php load_image($product["pd_image"]); ?>>
                            <p class="product-name" title="<?php echo $product["pd_name"]; ?>"><?php echo $product["pd_name"]; ?>
                            </p>
                            <p class="product-price"><?php convert_currency($product["pd_price"]); ?></p>
                            <a class="product-button" href="?direct=detail&pd_id=<?php echo $product["pd_id"]; ?>">Xem
                                sản phẩm</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
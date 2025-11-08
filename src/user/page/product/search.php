<?php
require_css("./src/user/css/product/search.css");
global $api;

$showResult = false;
$keyword = "";
$products = [];

if (isset($_GET["keyword"])) {
    $showResult = true;
    $keyword = $_GET["keyword"];
    $products = $api->get_products_by_keyword($keyword);
} else if (isset($_GET["min"]) && isset($_GET["max"])) {
    $showResult = true;
    $min = $_GET["min"];
    $max = $_GET["max"];
    $products = $api->get_products_in_range($min, $max);
}
?>

<div class="layout-container">
    <form class="search-form" method="get">
        <input type="hidden" name="direct" value="search">
        <label class="search-label" for="keyword">Từ khoá:</label>
        <input class="search-input" type="text" name="keyword" value="<?php echo $keyword; ?>">
        <input class="search-submit" type="submit" value="Tìm kiếm">
    </form>
    <div class="search-suggest">
        <form method="get">
            <input type="hidden" name="direct" value="search">
            <input type="hidden" name="min" value="0">
            <input type="hidden" name="max" value="100000">
            <input class="search-submit" type="submit" value="Dưới 100.000₫">
        </form>
        <form method="get">
            <input type="hidden" name="direct" value="search">
            <input type="hidden" name="min" value="100000">
            <input type="hidden" name="max" value="300000">
            <input class="search-submit" type="submit" value="100.000₫ - 300.000₫">
        </form>
        <form method="get">
            <input type="hidden" name="direct" value="search">
            <input type="hidden" name="min" value="300000">
            <input type="hidden" name="max" value="9007199254740991">
            <input class="search-submit" type="submit" value="Trên 300.000₫">
        </form>
    </div>
    <?php
    if ($showResult) {
        if (empty($products)) { ?>
            <p class="no-product">Không có dữ liệu</p>
        <?php } else { ?>
            <div class="search-result">
                <?php foreach ($products as $product) { ?>
                    <div class="product-item">
                        <img class="product-image" src=<?php load_image($product["pd_image"]); ?>>
                        <p class="product-name" title="<?php echo $product["pd_name"]; ?>"><?php echo $product["pd_name"]; ?></p>
                        <p class="product-price"><?php convert_currency($product["pd_price"]); ?></p>
                        <a class="product-button" href="?direct=detail&pd_id=<?php echo $product["pd_id"]; ?>">Xem sản phẩm</a>
                    </div>
                <?php } ?>
            </div>
        <?php }
    } ?>
</div>
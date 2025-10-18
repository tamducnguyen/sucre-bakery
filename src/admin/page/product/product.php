<?php
require_css("./src/admin/css/product/product.css");
global $api;

if (isset($_POST["action"])) {
    $pd_id = $_POST["pd_id"];

    switch ($_POST["action"]) {
        case "remove":
            $result = $api->remove_product($pd_id);
            toast($result["message"]);
            break;
    }
}

$itemPerPage = 3;
$allProducts = $api->get_products();
$totalPages = get_total_pages($itemPerPage, $allProducts);
$currentPage = get_current_page($totalPages);
$products = $api->get_products_by_page($currentPage, $itemPerPage);
?>

<p class="title">Danh sách sản phẩm</p>

<div class="list-item">
    <?php foreach ($products as $product) { ?>
        <div class="item">
            <div class="item-image">
                <img class="product-image" src=<?= load_image($product["pd_image"]) ?>>

                <div class="item-action">
                    <form action="?direct=edit_product" method="post">
                        <input type="hidden" name="pd_id" value="<?= $product["pd_id"] ?>">
                        <button class="edit-button" type="submit">Sửa</button>
                    </form>

                    <form method="post">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="pd_id" value="<?= $product["pd_id"] ?>">
                        <button class="remove-button" type="submit">Xóa</button>
                    </form>
                </div>
            </div>

            <div class="item-detail">
                <p class="product-name">
                    <?= $product["pd_name"] ?>
                </p>

                <p class="product-price">
                    <?= convert_currency($product["pd_price"]) ?>
                </p>

                <p class="product-type">
                    <?php
                    $productType = $api->get_product_type_by_id($product["pdt_id"]);
                    echo $productType["pdt_name"];
                    ?>
                </p>

                <p class="product-description" title="<?= $product["pd_description"] ?>">
                    <?= $product["pd_description"] ?>
                </p>
            </div>
        </div>
    <?php } ?>
</div>

<div class="page">
    <p class="text">Trang</p>

    <form method="get">
        <input type="hidden" name="direct" value="product">
        <input class="input" type="number" min="1" max="<?= $totalPages ?>" onchange="this.form.submit()" name="page"
            value="<?= $currentPage ?>">
    </form>

    <p class="text">
        / <?= $totalPages ?>
    </p>
</div>
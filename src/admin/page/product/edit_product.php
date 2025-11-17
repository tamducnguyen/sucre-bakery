<?php
require_css("./src/admin/css/product/handle.css");
global $api;

$pd_id = $_POST["pd_id"];
$product = $api->get_product_by_id($pd_id);

$pd_name = $product["pd_name"];
$pd_price = $product["pd_price"] / 1000;
$pd_description = $product["pd_description"];
$pdt_id = $product["pdt_id"];
$pd_image = $product["pd_image"];

if (isset($_POST["action"])) {
    if ($_POST["action"]=='edit') {
            $new_name = $_POST["pd_name"];
            $new_price = $_POST["pd_price"];
            $new_description = $_POST["pd_description"];
            $new_type = $_POST["pdt_id"];
            $new_image = $_FILES["pd_image"]["tmp_name"];
            $new_image_size = $_FILES["pd_image"]["size"];
            
            $max_size = 100 * 1024;

            if ($new_image_size > $max_size) {
                toast("Dung lượng ảnh phải nhỏ hơn 100KB!");
                exit;
            }

            $new_product = [];

            if ($new_name != $pd_name) {
                $new_product["pd_name"] = $new_name;
            }

            if ($new_price != $pd_price) {
                $new_product["pd_price"] = $new_price * 1000;
            }

            if ($new_description != $pd_description) {
                $new_product["pd_description"] = $new_description;
            }

            if ($new_type != $pdt_id) {
                $new_product["pdt_id"] = $new_type;
            }

            if ($new_image != "") {
                $new_product["pd_image"] = $new_image;
            }

            $result = $api->edit_product($pd_id, $new_product);

            if ($result["success"]) {
                set_toast_message($result["message"]);
                redirect("?direct=product");
            } else {
                toast($result["message"]);
            }

    }
}
?>

<p class="title">Sửa sản phẩm</p>

<form class="container" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="pd_id" value="<?= $pd_id ?>">

    <div class="form-container">
        <div class="form">
            <div class="group">
                <p class="label">Tên sản phẩm:</p>
                <input class="input" type="text" name="pd_name" value="<?= $pd_name ?>">
            </div>

            <div class="group">
                <p class="label">Giá:</p>
                <div class="price">
                    <input class="input" type="number" min="0" name="pd_price" value="<?= $pd_price ?>">
                    <p class="note">
                        (đơn vị nghìn đồng)
                    </p>
                </div>
            </div>

            <div class="group">
                <p class="label">Mô tả:</p>
                <textarea class="input" name="pd_description" rows="5"><?= $pd_description ?></textarea>
            </div>

            <div class="group">
                <p class="label">Loại:</p>
                <select class="input" name="pdt_id">
                    <?php
                    $productTypes = $api->get_product_types();

                    foreach ($productTypes as $productType) {
                        $productTypeId = $productType["pdt_id"];
                        $productTypeName = $productType["pdt_name"]; ?>

                        <option value="<?= $productTypeId ?>" <?= $productTypeId == $pdt_id ? "selected" : "" ?>>
                            <?= $productTypeName ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button class="submit-button" type="submit">Sửa</button>
        </div>
    </div>

    <div class="image-container">
        <img class="product-image" src=<?= load_image($pd_image) ?>>

        <input class="upload" type="file" name="pd_image" accept="image/*">
    </div>
</form>
<?php
require_css("./src/admin/css/product/handle.css");
global $api;

if (isset($_POST["action"])) {
    if ($_POST["action"]=='add') {
            $pd_name = $_POST["pd_name"];
            $pd_price = $_POST["pd_price"] * 1000;
            $pd_description = $_POST["pd_description"];
            $pd_type = $_POST["pdt_id"];
            $pd_image = $_FILES["pd_image"]["tmp_name"];
            $image_size = $_FILES["pd_image"]["size"];

            $max_size = 100 * 1024;

            if ($image_size > $max_size) {
                toast("Dung lượng ảnh phải nhỏ hơn 100KB!");
                exit;
            }

            $result = $api->add_product($pd_name, $pd_price, $pd_description, $pd_type, $pd_image);

            if ($result["success"]) {
                set_toast_message($result["message"]);
                redirect("?direct=product");
            } else {
                toast($result["message"]);
            }
    }
}
?>

<p class="title">Thêm sản phẩm</p>

<form class="container" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="pd_id" value="<?= $pd_id ?>">

    <div class="form-container">
        <div class="form">
            <div class="group">
                <p class="label">Tên sản phẩm:</p>
                <input class="input" type="text" name="pd_name" required>
            </div>

            <div class="group">
                <p class="label">Giá:</p>
                <div class="price">
                    <input class="input" type="number" min="0" name="pd_price" required>
                    <p class="note">
                        (đơn vị nghìn đồng)
                    </p>
                </div>
            </div>

            <div class="group">
                <p class="label">Mô tả:</p>
                <textarea class="input" name="pd_description" rows="5" required></textarea>
            </div>

            <div class="group">
                <p class="label">Loại:</p>
                <select class="input" name="pdt_id">
                    <?php
                    $productTypes = $api->get_product_types();

                    foreach ($productTypes as $productType) {
                        $productTypeId = $productType["pdt_id"];
                        $productTypeName = $productType["pdt_name"]; ?>

                        <option value="<?= $productTypeId ?>">
                            <?= $productTypeName ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button class="submit-button" type="submit">Thêm</button>
        </div>
    </div>

    <div class="image-container">
        <img class="product-image" src="./public/img/recommend.jpg">

        <input class="upload" type="file" name="pd_image" accept="image/*" required>
    </div>
</form>
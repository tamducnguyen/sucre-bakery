<?php
trait Product
{
    function get_count_products()
    {
        $sql = "SELECT COUNT(*) as count
                FROM `product`;";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc()["count"];
    }

    function get_products_by_page($page, $itemPerPage)
    {
        $indexPage = ($page - 1) * $itemPerPage;

        $sql = "SELECT *
                FROM `product`
                ORDER BY `pd_last_update` DESC
                LIMIT $indexPage, $itemPerPage;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function get_products_by_keyword($keyword)
    {
        $sql = "SELECT *
                FROM `product`
                WHERE `pd_name` LIKE '%$keyword%'
                ORDER BY `pd_id` ASC;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function get_product_by_id($pd_id)
    {
        $sql = "SELECT *
                FROM `product`
                WHERE `pd_id` = '$pd_id';";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function get_products_by_type($pdt_id)
    {
        $sql = "SELECT *
                FROM `product`
                WHERE `pdt_id` = '$pdt_id'
                ORDER BY `pdt_id` ASC;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function get_product_type_by_id($pdt_id)
    {
        $sql = "SELECT *
                FROM `product_type`
                WHERE `pdt_id` = '$pdt_id';";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function get_product_types()
    {
        $sql = "SELECT *
                FROM `product_type`
                ORDER BY `pdt_id` ASC;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function get_products_in_range($min, $max)
    {
        $sql = "SELECT *
                FROM `product`
                WHERE `pd_price` BETWEEN '$min' AND '$max'
                ORDER BY `pd_id` ASC;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function add_product($pd_name, $pd_price, $pd_description, $pdt_id, $pd_image)
    {
        $pd_image = "0x" . bin2hex(file_get_contents($pd_image));

        // pd_image is image so doesn't need to put into ''
        $sql = "INSERT INTO `product` (`pd_name`, `pd_price`, `pd_description`, `pdt_id`, `pd_image`, `pd_last_update`)
                VALUES ('$pd_name', '$pd_price', '$pd_description', '$pdt_id', $pd_image, NOW());";

        try {
            $this->connection->query($sql);
            return [
                "success" => true,
                "message" => "Đã thêm thành công!"
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => $th->getMessage()
            ];
        }
    }

    function remove_product($pd_id)
    {
        $sql = "DELETE FROM `product`
                WHERE `pd_id` = '$pd_id';";

        try {
            $this->connection->query($sql);
            return [
                "success" => true,
                "message" => "Đã xoá thành công!"
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => $th->getMessage()
            ];
        }
    }

    function edit_product($pd_id, $product)
    {
        $update = "";

        foreach ($product as $key => $value) {
            if ($key == "pd_image") {
                $pd_image = "0x" . bin2hex(file_get_contents($value));

                // pd_image is image so doesn't need to put into ''
                $update .= "`$key` = $pd_image,";
            } else {
                $update .= "`$key` = '$value',";
            }
        }

        // Avoid spamming button when nothing changes
        if ($update == "") {
            return [
                "success" => true,
                "message" => "Không có gì cập nhật!"
            ];
        }

        $update .= "`pd_last_update` = NOW()";

        $sql = "UPDATE `product`
                SET $update
                WHERE `pd_id` = '$pd_id';";

        try {
            $this->connection->query($sql);
            return [
                "success" => true,
                "message" => "Đã cập nhật thành công!"
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => $th->getMessage()
            ];
        }
    }
}
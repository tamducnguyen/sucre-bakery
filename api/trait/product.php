<?php
trait Product
{
    function get_products()
    {
        $sql = "SELECT *
                FROM `product`
                ORDER BY `pd_id` ASC;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
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

}
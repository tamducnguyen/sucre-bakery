<?php
trait Order
{
    function create_order($us_id, $order)
    {
        $od_id = $order["od_id"];
        $od_created_on = $order["od_created_on"];
        $od_delivery_time = $order["od_delivery_time"];
        $od_person_receive = $order["od_person_receive"];
        $od_address = $order["od_address"];
        $od_number_phone = $order["od_number_phone"];
        $od_price = $order["od_price"];

        $sql = "INSERT INTO `order` (`od_id`, `od_created_on`, `od_delivery_time`,
                                     `od_person_receive`, `od_address`, `od_number_phone`,
                                     `od_price`, `us_id`, `os_id`, `ad_id`)
                VALUES ('$od_id', '$od_created_on', '$od_delivery_time', '$od_person_receive',
                        '$od_address', '$od_number_phone', '$od_price', '$us_id', '1', NULL);";

        try {
            $this->connection->query($sql);
            $this->add_to_product_order($us_id, $od_id);
            return [
                "success" => true,
                "message" => "Đã đặt hàng thành công!"
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => $th->getMessage()
            ];
        }
    }

    function add_to_product_order($us_id, $od_id)
    {
        $sql = "INSERT INTO `product_order` (`od_id`, `pod_name`, `pod_quantity`,
                            `pod_price`, `pod_created_on`)
                SELECT '$od_id', pd.`pd_name`, ca.`ca_quantity`,
                       pd.`pd_price`, ca.`ca_created_on`
                FROM `cart` as ca
                INNER JOIN `product` as pd
                WHERE ca.`pd_id` = pd.`pd_id`
                AND ca.`us_id` = '$us_id';";

        $this->connection->query($sql);
    }

    function get_history_order($us_id)
    {
        $sql = "SELECT *
                FROM `order` as od
                INNER JOIN `order_status` as os
                ON od.`os_id` = os.`os_id`
                WHERE od.`us_id` = '$us_id'
                ORDER BY od.`od_created_on` DESC;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function get_order_info($od_id)
    {
        $sql = "SELECT *
                FROM `order` as od
                INNER JOIN `order_status` as os
                ON od.`os_id` = os.`os_id`
                INNER JOIN `user` as us
                ON od.`us_id` = us.`us_id`
                WHERE od.`od_id` = '$od_id';";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function get_order_products_info($od_id)
    {
        $sql = "SELECT *
                FROM `product_order`
                WHERE `od_id` = '$od_id'
                ORDER BY `pod_created_on` ASC;";
                
        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
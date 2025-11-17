<?php
trait Statistic
{
    /**
     * Get the number of orders with a specific status.
     *
     * @param $status 1 => wait,
     *                2 => work,
     *                3 => done,
     *                4 => cancel
     */
    function get_order_count_by_status($status)
    {
        $sql = "SELECT COUNT(*) as count
                FROM `order` as od
                INNER JOIN `order_status` as os
                ON od.`os_id` = os.`os_id`
                WHERE od.`os_id` = '$status';";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc()["count"];
    }

    /**
     * Get the orders with a specific status.
     *
     * @param $status 1 => wait,
     *                2 => work,
     *                3 => done,
     *                4 => cancel
     */

    /**
     * Get the orders with a specific status on a specific page.
     *
     * @param $status 1 => wait,
     *                2 => work,
     *                3 => done,
     *                4 => cancel
     * @param $page which page
     * @param $itemPerPage how many items per page
     */
    function get_orders_by_status_on_page($status, $page, $itemPerPage)
    {
        $indexPage = ($page - 1) * $itemPerPage;

        $sql = "SELECT *
                FROM `order` as od
                INNER JOIN `order_status` as os
                ON od.`os_id` = os.`os_id`
                WHERE od.`os_id` = '$status'
                ORDER BY od.`od_created_on` DESC
                LIMIT $indexPage, $itemPerPage;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function get_order_statuses()
    {
        $sql = "SELECT *
                FROM `order_status`
                ORDER BY `os_id` ASC;";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function get_order_status($od_id)
    {
        $sql = "SELECT *
                FROM `order` as od
                INNER JOIN `order_status` as os
                ON od.`os_id` = os.`os_id`
                WHERE od.`od_id` = '$od_id';";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function get_checker($od_id)
    {
        $sql = "SELECT *
                FROM `order` as od
                INNER JOIN `admin` as ad
                ON od.`ad_id` = ad.`ad_id`
                WHERE od.`od_id` = '$od_id';";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    function update_order_status($od_id, $os_id)
    {
        $sql = "UPDATE `order`
                SET `os_id` = '$os_id'
                WHERE `od_id` = '$od_id';";

        $this->connection->query($sql);
    }

    function update_checker($od_id, $ad_id)
    {
        $sql = "UPDATE `order`
                SET `ad_id` = '$ad_id'
                WHERE `od_id` = '$od_id';";

        $this->connection->query($sql);
    }
}
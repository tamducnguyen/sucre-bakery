<?php
require __DIR__ . "/./trait/product.php";
require __DIR__ . "/./trait/cart.php";
require __DIR__ . "/./trait/account.php";
require __DIR__ . "/./trait/order.php";
require __DIR__ . "/./trait/statistic.php";

class Api
{
    private $connection;

    function __construct()
    {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "db_sucre_web";
        $this->connection = new mysqli($hostname, $username, $password, $database);
    }

    use Product;
    use Cart;
    use Account;
    use Order;
    use Statistic;
}

$api = new Api();
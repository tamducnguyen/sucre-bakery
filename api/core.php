<?php
require __DIR__ . "/./trait/product.php";
require __DIR__ . "/./trait/account.php";

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

    use Account;
    use Product;
}

$api = new Api();
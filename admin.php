<?php
require __DIR__ . "/./api/core.php";
require __DIR__ . "/./src/util/require_css.php";
require __DIR__ . "/./src/util/load_image.php";
require __DIR__ . "/./src/util/convert_currency.php";
require __DIR__ . "/./src/util/checker.php";
require __DIR__ . "/./src/util/toast.php";
require __DIR__ . "/./src/util/page.php";
require __DIR__ . "/./src/util/redirect.php";
require __DIR__ . "/./src/util/constant.php";
require __DIR__ . "/./src/util/convert_datetime.php";

session_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/reset-css@5.0.2/reset.css" type="text/css" />
    <link rel="stylesheet" href="./index.css" type="text/css" />
    <title>Quản trị viên</title>
</head>

<body>
    <?php
    toast_session();

    switch (DIRECT) {
        // Account
        case "login":
            block_login_admin();
            require "./src/admin/page/login.php";
            break;

        // Else
        default:
            authorize_admin();
            require "./src/admin/page/home.php";
            break;
    }
    ?>
</body>

</html>
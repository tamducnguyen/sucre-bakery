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
    <title>Sucré Bakery</title>
</head>

<body>
    <?php
    toast_session();

    // Header
    require "./src/user/page/header.php";

    switch (DIRECT) {
        // Account
        case "login":
            block_login_user();
            require "./src/user/page/account/login.php";
            break;

        case "modify":
            authorize_user();
            require "./src/user/page/account/modify.php";
            break;

        case "register":
            block_login_user();
            require "./src/user/page/account/register.php";
            break;

        // Product
        case "detail":
            require "./src/user/page/product/detail.php";
            break;

        case "product":
            require "./src/user/page/product/product.php";
            break;


        // Footer
        case "address":
            require "./src/user/page/footer/address.php";
            break;

        case "contact":
            require "./src/user/page/footer/contact.php";
            break;

        case "intro":
            require "./src/user/page/footer/intro.php";
            break;

        case "policy":
            require "./src/user/page/footer/policy.php";
            break;

        case "term":
            require "./src/user/page/footer/term.php";
            break;

        // Else
        case "home":
            require "./src/user/page/home.php";
            break;
    }

    // Footer
    require "./src/user/page/footer/footer.php";
    ?>
</body>

</html>
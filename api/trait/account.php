<?php
trait Account
{
    function login_admin($ad_name, $ad_password)
    {
        $sql = "SELECT *
                FROM `admin`
                WHERE `ad_name` = '$ad_name';";

        $result = $this->connection->query($sql)->fetch_assoc();

        if (empty($result)) {
            return [
                "success" => false,
                "message" => "Tài khoản không tồn tại!"
            ];
        }

        if ($result["ad_password"] != $ad_password) {
            return [
                "success" => false,
                "message" => "Sai mật khẩu!"
            ];
        }

        $_SESSION["ad_info"] = $result;
        return [
            "success" => true,
            "message" => "Đăng nhập thành công!"
        ];
    }

    function login_user($us_number_phone, $us_password)
    {
        $sql = "SELECT *
                FROM `user`
                WHERE `us_number_phone` = '$us_number_phone';";

        $result = $this->connection->query($sql)->fetch_assoc();

        if (empty($result)) {
            return [
                "success" => false,
                "message" => "Tài khoản không tồn tại!"
            ];
        }

        if ($result["us_password"] != $us_password) {
            return [
                "success" => false,
                "message" => "Sai mật khẩu!"
            ];
        }

        $_SESSION["us_info"] = $result;
        return [
            "success" => true,
            "message" => "Đăng nhập thành công!"
        ];
    }

    function register_user($us_name, $us_number_phone, $us_password)
    {
        $sql = "SELECT *
                FROM `user`
                WHERE `us_number_phone` = '$us_number_phone';";

        $result = $this->connection->query($sql)->fetch_assoc();

        if (!empty($result)) {
            return [
                "success" => false,
                "message" => "Tài khoản đã tồn tại!"
            ];
        }

        $sql = "INSERT INTO `user` (`us_name`, `us_number_phone`, `us_password`, `us_address`) 
                VALUES ('$us_name', '$us_number_phone', '$us_password', '');";

        try {
            $this->connection->query($sql);
            $_SESSION["us_info"] = $result;
            return [
                "success" => true,
                "message" => "Đăng ký thành công!"
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => $th->getMessage()
            ];
        }
    }

    function edit_user($us_id, $user)
    {
        $update = "";

        foreach ($user as $key => $value) {
            $update .= "`$key` = '$value',";
        }

        // Avoid spamming button when nothing changes
        if ($update == "") {
            return [
                "success" => true,
                "message" => "Không có gì cập nhật!"
            ];
        }

        $update = rtrim($update, ',');

        $sql = "UPDATE `user`
                SET $update
                WHERE `us_id` = '$us_id';";

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

    function get_user_info()
    {
        $us_info = $_SESSION["us_info"] ?? null;

        if (!$us_info) {
            return null;
        }

        $us_number_phone = $us_info["us_number_phone"];

        $sql = "SELECT *
                FROM `user`
                WHERE `us_number_phone` = '$us_number_phone';";

        $result = $this->connection->query($sql)->fetch_assoc();

        $_SESSION["us_info"] = $result;
        return $_SESSION["us_info"];
    }

    function get_admin_info()
    {
        $ad_info = $_SESSION["ad_info"] ?? null;

        if (!$ad_info) {
            return null;
        }

        $ad_name = $ad_info["ad_name"];

        $sql = "SELECT *
                FROM `admin`
                WHERE `ad_name` = '$ad_name';";

        $result = $this->connection->query($sql)->fetch_assoc();

        $_SESSION["ad_info"] = $result;
        return $_SESSION["ad_info"];
    }

}
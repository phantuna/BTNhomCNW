<?php

function getDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BTTH01_CSE485";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    return $conn;
}


class User {
    public static function count() {
        $conn = getDatabaseConnection();
        $result = $conn->query("SELECT COUNT(*) as total FROM users");
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0;
    }
}

class Categories {
    public static function count() {
        $conn = getDatabaseConnection();
        $result = $conn->query("SELECT COUNT(*) as total FROM theloai");
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0;
    }
}

class Authors {
    public static function count() {
        $conn = getDatabaseConnection();
        $result = $conn->query("SELECT COUNT(*) as total FROM tacgia");
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0;
    }
}

class Articles {
    public static function count() {
        $conn = getDatabaseConnection();
        $result = $conn->query("SELECT COUNT(*) as total FROM baiviet");
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0;
    }
}
?>

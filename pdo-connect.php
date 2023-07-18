<?php
$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "key_traveler";

try {
    $db_host = new PDO(
        "mysql:host={$servername};
         dbname={$dbname};
         charset=utf8",
        $username,
        $password
    );
} catch (PDOException $e) {
    echo "資料庫連線失敗<br>";
    echo "Error: " . $e->getMessage();
}

// echo "資料庫連線成功";

// $db_host=null;

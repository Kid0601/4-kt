<?php
$email = $_POST["email"];
$password = $_POST["password"];

echo $email . '<br>';
echo $password . '<br>';


$email === "admin@ispan.com" &  $password === "12345" ? header("location:index.php") : die('無管理權限');

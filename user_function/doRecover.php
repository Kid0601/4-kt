<?php
if (!isset($_GET["id"])) {
    die("無法作業");
}
require_once("db_connect_small_project.php");
$id = $_GET["id"];
echo $id;
$sql = "UPDATE users SET valid=1 WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("location:dashboard.php");
} else {
    echo "回複失敗";
}

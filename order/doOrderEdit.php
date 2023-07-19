<?php
require_once("../db_connect.php");

$id=$_POST["id"];
$status=$_POST["status"];
echo "$id, $status";

$sql="UPDATE user_order SET status='$status' WHERE id='$id' ";
echo $sql;
if($conn->query($sql)===TRUE){
  header("location: user_order.php");
}

$conn->close();
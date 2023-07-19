<?php
require_once("../db_connect.php");

$id = $_POST["id"];
$title = $_POST["title"];
$article = $_POST["article"];
$article_category = $_POST["article_category"];
$valid = $_POST["valid"];

include("json_encode.php");
// echo $jsonDataArrayString;
if ($jsonDataArrayString !== '""') {
    $sql_img = "UPDATE article SET img='$jsonDataArrayString' WHERE id=$id";
    $conn->query($sql_img);
}
// $sql = "UPDATE article SET title='$title', article='$article', article_category='$article_category', valid='$valid', img='$jsonDataArrayString' WHERE id=$id";
$sql = "UPDATE article SET title='$title', article='$article', article_category='$article_category', valid='$valid' WHERE id=$id";
if ($conn->query($sql) === TRUE) {

    header("location: article.php");
} else {
    echo "修改增資料錯誤: " . $conn->error;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>doUpdate</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
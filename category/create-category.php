<?php
require_once("../db_connect.php");

$sql_1 = "SELECT category_1.* FROM category_1 ORDER BY category_1.id ASC";
$result1 = $conn->query($sql_1);
$rows1 = $result1->fetch_all(MYSQLI_ASSOC);

$sql_2 = "SELECT category_2.* FROM category_2 ORDER BY category_2.id ASC";
$result2 = $conn->query($sql_2);
$rows2 = $result2->fetch_all(MYSQLI_ASSOC);

// echo '<pre>';
// var_dump($rows1);
// var_dump($rows2);
// echo '</pre>';
?>

<!doctype html>
<html lang="en">

<head>
    <title>新增類別</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="py-2">
            <a href="category-list.php" class="btn btn-info">回類別管理列表</a>
        </div>

        <form action="doCreateCategory.php" method="post" class="w-50 m-auto d-flex flex-column align-items-start">
            <div class="mb-2">
                <label for="" class="fs-4">商品類別</label>
                <input type="text" class="form-control" name="cat1_name">
                <label for="" class="fs-4">子類別</label>
                <input type="text" class="form-control" name="cat2_name">
            </div>
            <button class="btn btn-success" type="submit">送出</button>
        </form>
    </div>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
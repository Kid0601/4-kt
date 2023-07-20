<?php
// if (!isset($_GET["id"])) {
//     die("資料不存在");
//     header("location: /404.php");
// }

$id = $_GET["id"];

require_once("../db_connect.php");

$sql_1 = "SELECT category_1.* FROM category_1 WHERE id=$id AND valid=1";
$result1 = $conn->query($sql_1);
$row1 = $result1->fetch_assoc();

$sql_2 = "SELECT category_2.* FROM category_2 WHERE parent_category=$id AND valid=1 ORDER BY category_2.id ASC";
$result2 = $conn->query($sql_2);
$rows2 = $result2->fetch_all(MYSQLI_ASSOC);

// echo '<pre>';
// var_dump($row1);
// var_dump($rows2);
// echo '</pre>';
?>

<!doctype html>
<html lang="en">

<head>
    <title>Category Edit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div style="height: 10px;"></div>
        <h1 class="text-align-center">編輯類別名稱</h1>
        <form action="doUpdateCategory.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <table class="table table-bordered">
                <tr>
                    <th class="h3">商品類別</th>
                    <td>
                        <input type="text" class="form-control" value="<?= $row1["name"] ?>" name="cat1_name">
                        <input type="hidden" name="cat1_id" value="<?= $id ?>">
                    </td>
                </tr>
                <tr>
                    <th class="h3">子類別</th>
                    <td>
                        <?php foreach ($rows2 as $index => $row2) : ?>
                            <input type="text" class="form-control my-1" value="<?= $row2["name"] ?>" name="cat2_name[]">
                            <input type="hidden" name="cat2_id[]" value="<?= $row2["id"] ?>">
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
            <div class="py-2 d-flex justify-content-end">
                <a class="btn btn-info me-2" href="category-list.php">取消</a>
                <button class="btn btn-info" type="submit">儲存變更</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>
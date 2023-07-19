<?php
require_once("../db_connect.php");

$id = $_POST["id"];
$name = $_POST["name"];


$sql = "SELECT * FROM rent where id LIKE '$id' OR  name LIKE '%$name%'";
// $sqlId="SELECT * FROM rent where id LIKE '%$id%'";
if(empty($name)){
    $sql = "SELECT * FROM rent WHERE id LIKE '$id'";
};

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);

// 網頁 title
$title = "商品查詢";

?>
<!DOCTYPE html>
<html lang="en">

<!-- head -->
<?php include("../template/head.php") ?>

<body class="sb-nav-fixed pe-0">
    <!-- navbar -->
    <?php include("../template/navbar.php") ?>
    <div id="layoutSidenav">
        <!-- sideBar -->
        <?php include("../template/sideBar.php"); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $title ?></h1>
                    <!-- breadcrumb -->
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">租用商品管理</li>
                        <li class="breadcrumb-item"><a href="rent_list.php" class="text-decoration-none text-reset"> 商品列表</a></li>
                        <li class="breadcrumb-item active">商品查詢</li>
                    </ol>

                    <div class="mb-3">
                        <div class="d-flex">
                            <select class="me-2 form-control-sm" name="rentSelect" id="rentSelect">
                                <option value="name">商品名稱</option>
                                <option value="id">商品編號</option>
                            </select>

                            <form action="rent_search.php" method="post" class="d-flex">
                                <div class="me-3">
                                    <input type="text" name="name" class="form-control" id="searchName" placeholder="商品名稱">
                                    <input type="text" name="id" class="form-control" id="searchId" placeholder="商品編號">
                                </div>
                                <button class="btn btn-secondary" type="submit">搜尋</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>商品編號</th>
                                    <th>商品名稱</th>
                                    <th>商品圖片</th>
                                    <th>租金</th>
                                    <th>庫存</th>
                                    <th>狀態</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($rows as $row) : ?>
                                    
                                    <tr>
                                        <td><?= $row["id"] ?></td>
                                        <td><?= $row["name"] ?></td>
                                        <td>
                                            <figure class="ratio ratio-1x1">
                                                <img src="../rent_img/<?= $row["img"] ?>" alt="">
                                            </figure>
                                        </td>
                                        <td><?= $row["price"] ?></td>
                                        <td><?= $row["quantity"] ?></td>

                                        <td>
                                            <?php
                                            switch ($row["valid"]) {
                                                case 0:
                                                    echo "上架";
                                                    break;
                                                case 1:
                                                    echo "下架";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td><a class="btn btn-secondary" href="rent_edit.php?id=<?= $row["id"] ?>&page=<?= ceil($row["id"] / 5) ?>">編輯</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <a href="rent_list.php" class="btn btn-secondary">返回商品列表 </a>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>


    <script>
        const rentSelect = document.querySelector("#rentSelect")
        const searchName = document.querySelector("#searchName")
        const searchId = document.querySelector("#searchId")

        searchId.style.display = "none"

        function selectChange() {
            const rentSelectValue = rentSelect.value
            if (rentSelectValue == "id") {
                searchName.style.display = "none"
                searchId.style.display = "block"
            } else {
                searchName.style.display = "block"
                searchId.style.display = "none"
            }
        }
        rentSelect.addEventListener("change", selectChange)
    </script>
</body>

</html>
<?php
// 網頁 title
$title = "商品列表";

require_once("../db_connect.php");
// 找商品的資訊
$sql = "SELECT product.*, category_1.name AS c1_name, category_2.name AS c2_name
        FROM product
        JOIN category_1 ON product.category_1 = category_1.c1_id
        JOIN category_2 ON product.category_2 = category_2.c2_id
        WHERE valid = 1 AND is_groupBy = 0
        ORDER BY id ASC";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

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
                        <li class="breadcrumb-item">商品管理</li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->
                        <div class="card-body">
                            <div>

                            </div>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>商品名稱</th>
                                        <th>品牌</th>
                                        <th>商品類別</th>
                                        <th>商品價格</th>
                                        <th>商品庫存</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <!-- 確認刪除框框 -->
                                        <div class="modal fade" id="infoModal<?= $product["id"] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">確認刪除</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>是否刪除商品 <?= $product["id"] ?>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                        <a class="btn btn-danger" href="doDelete.php?id=<?= $product["id"] ?>">刪除</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td><?= $product["id"] ?></td>
                                            <td>
                                                <?= $product["name"] ?>
                                            </td>
                                            <td><?= $product["brand"] ?></td>
                                            <td><?= $product["c1_name"] ?> / <?= $product["c2_name"] ?></td>
                                            <td><?= $product["price"] ?></td>
                                            <td><?= $product["quantity"] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="product.php?mode=info&id=<?= $product["id"] ?>" title="詳細資訊" class="btn btn-link px-1">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </a>
                                                    <a href="product.php?mode=edit&id=<?= $product["id"] ?>" title="編輯" class="btn btn-link px-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <button title="刪除" type="button" data-bs-toggle="modal" data-bs-target="#infoModal<?= $product["id"] ?>" class="btn btn-link px-1 deleteBtn">
                                                        <i class="fa-solid fa-trash text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>
    <script>
        const deleteBtn = document.querySelectorAll(".deleteBtn");
        deleteBtn.forEach(item => {
            item.addEventListener("click", function() {
                console.log("<?= $product["id"] ?>");
            })
        })
    </script>
</body>

</html>
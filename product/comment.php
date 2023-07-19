<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title
$title = "商品評論";

require_once("../db_connect.php");

$sql = "SELECT comment.*, product.name AS product_name, users.account AS user_account FROM comment
        JOIN product ON product.id = comment.product_id
        JOIN users ON users.id = comment.user_id
        WHERE comment.valid = 1";
$result = $conn->query($sql);
$comments = $result->fetch_all(MYSQLI_ASSOC);

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
                        <!-- 你有幾層就複製幾個 -->
                        <li class="breadcrumb-item">商品管理</li>
                        <li class="breadcrumb-item active">商品評論</li>
                    </ol>
                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->
                        <div class="card-body">
                            <table class="table table-bordered" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>會員</th>
                                        <th>商品</th>
                                        <th>評價分數</th>
                                        <th>商品評論</th>
                                        <th>評價時間</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comments as $comment) : ?>
                                        <!-- 確認刪除框框 -->
                                        <div class="modal fade" id="deleteModal<?= $comment["id"] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">確認刪除</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>是否刪除評論 <?= $comment["id"] ?>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                        <a class="btn btn-danger" href="commentDelete.php?id=<?= $comment["id"] ?>">刪除</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td><?= $comment["id"] ?></td>
                                            <td><?= $comment["user_account"] ?></td>
                                            <td><?= $comment["product_name"] ?></td>
                                            <td><?= $comment["star"] ?></td>
                                            <td><?= $comment["comment"] ?></td>
                                            <td><?= $comment["created_at"] ?></td>
                                            <td>
                                                <button title="刪除" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $comment["id"] ?>" class="btn btn-link p-1 deleteBtn">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
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
</body>

</html>
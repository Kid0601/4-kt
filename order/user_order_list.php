<?php
require_once("../db_connect.php");

$id = $_GET["id"];


$sql = "SELECT user_order_list.*, user_order.status, user_order.order_date, product.name AS product_name, product.price, user_profile.*
FROM user_order_list
JOIN user_order ON user_order.id=user_order_list.order_id
JOIN product ON product.id= user_order_list.product_id
JOIN user_profile ON user_profile.user_id = user_order.user_id
WHERE user_order_list.order_id = $id
ORDER BY order_id ASC";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// 網頁 title
$title = "訂單資料";

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
                        <li class="breadcrumb-item">訂單管理</li>
                        <li class="breadcrumb-item"><a href="user_order.php" class="text-decoration-none text-reset">訂單列表</a></li>
                        <li class="breadcrumb-item active">訂單資料</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- 訂單資訊 -->
                            <table class="table table-bordered my-3">
                                <tr>
                                    <th>訂購編號</th>
                                    <td>
                                        <?= $rows[0]["order_id"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>訂購人</th>
                                    <td>
                                        <?= $rows[0]["last_name"] . $rows[0]["first_name"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>電話</th>
                                    <td>
                                        <?= $rows[0]["phone"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>地址</th>
                                    <td>
                                        <?= $rows[0]["address"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>訂單狀態</th>
                                    <td>
                                        <?php
                                        switch ($rows[0]["status"]) {
                                            case 0:
                                                echo "待出貨";
                                                break;
                                            case 1:
                                                echo "已出貨";
                                                break;
                                            case 2:
                                                echo "已送達";
                                                break;
                                            case 3:
                                                echo "已取貨";
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>下單時間</th>
                                    <td>
                                        <?= $rows[0]["order_date"]  ?>
                                    </td>
                                </tr>
                            </table>
                            <!-- 訂單商品資訊 -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                        <th>商品編號</th>
                                        <th>商品名稱</th>
                                        <th>單價</th>
                                        <th>數量</th>
                                        <th>小計</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0 ?>
                                    <?php foreach ($rows as $row) : ?>
                                        <tr>
                                            <td><?= $row["product_id"] ?></td>
                                            <td><?= $row["product_name"] ?></td>
                                            <td><?= $row["price"] ?></td>
                                            <td><?= $row["amount"] ?></td>
                                            <td>
                                                <?php
                                                $subtotal = $row["price"] * $row["amount"];
                                                $total += $subtotal;
                                                ?>
                                                <?= $subtotal; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="text-end" colspan="5">總金額:<?= $total ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="user_order.php" class="btn btn-secondary">返回訂單列表</a>
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
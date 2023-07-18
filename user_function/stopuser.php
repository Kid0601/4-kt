<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title
require_once("db_connect_small_project.php");


//分頁功能
$page = $_GET["page"] ?? 1;
$startItem = ($page - 1) * 10;
//查詢停權名單資料庫
$sqlStop = "SELECT * FROM users WHERE valid=0 LIMIT $startItem,10";
$resultStop = $conn->query($sqlStop);
$rowsStop = $resultStop->fetch_all(MYSQLI_ASSOC);

//計算總頁數
$sqlPages = "SELECT * FROM users WHERE valid=0 ";
$resultTotalPages = $conn->query($sqlPages);
$totalPages = $resultTotalPages->num_rows;
$pages = ceil($totalPages / 10); //計算總共有幾頁

$title = "停權名單";

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
                        <li class="breadcrumb-item">會員管理</li>
                        <li class="breadcrumb-item active">停權名單</li>
                    </ol>

                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->

                        <div class="card-body">

                            <div class="container-fluid px-4">
                                <!-- 停權名單 -->
                                <div class="stopUser card mb-4">
                                    <div class="card-header d-flex align-items-center">
                                        <i class="fas fa-table me-1"></i>
                                        <p class="my-0 pe-2">停權會員資料列表</p>
                                        <p class="breadcrumb-item active my-0">共計:<?= $totalPages; ?> 筆</p>

                                    </div>

                                    <div class="card-body">
                                        <!------------------------------------------------  輸入表格--------------------------------------------------------------->
                                        <!-- id="datatablesSimple" 大絕 -->
                                        <table class="table " id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Account</th>
                                                    <th>Password</th>
                                                    <th>Email</th>
                                                    <th>VIP</th>
                                                    <th>operation</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach ($rowsStop as $usersStop) :; ?>
                                                    <tr>
                                                        <td><?= $usersStop["id"]  ?></td>
                                                        <td><?= $usersStop["account"]  ?></td>
                                                        <td><?= $usersStop["password"]  ?></td>
                                                        <td><?= $usersStop["email"]  ?></td>
                                                        <td><?php
                                                            if ($usersStop["vip"] == 0) {
                                                                echo "普通會員";
                                                                echo "<img src='user0.svg' style='width:30px;' class='ms-2' alt=''>";
                                                            } elseif ($usersStop["vip"] == 1) {
                                                                echo "銀會員";
                                                                echo "<img src='user1.svg' style='width:30px;' class='ms-2' alt=''>";
                                                            } elseif ($usersStop["vip"] == 2) {
                                                                echo "金會員";
                                                                echo "<img src='user2.svg' style='width:30px;' class='ms-2' alt=''>";
                                                            } else {
                                                                echo "怪東西";
                                                            }
                                                            ?>
                                                            <!-- <img src="" alt=""> -->
                                                        </td>
                                                        <td>
                                                            <a href="doRecover.php?id=<?= $usersStop["id"] ?>" class="btn btn-dark">Recover</a>
                                                            <a href="doDelete.php?id=<?= $usersStop["id"] ?>" class="btn btn-dark">刪除會員資料</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <!-- 停權頁籤 -->
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item"><a class="page-link text-dark" href="stopuser.php?page=<?= $page - 1 == 0 ? $page = 1 : $page - 1   ?>">Previous</a></li>
                                        <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                            <li class="page-item"><a class="page-link text-dark" href="stopuser.php?page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php endfor ?>
                                        <li class="page-item"><a class="page-link text-dark" href="stopuser.php?page=<?= $page + 1 <= $pages ? $page + 1 : $page ?>">Next</a></li>
                                    </ul>
                                </nav>


                                <div class="operation py-3">
                                    <h3>管理者操作面板</h3>
                                    <div class="operation-content">
                                        <a href="/key_traveler/user_function/dashboard.php"><button class="btn btn-dark">回到會員資料</button></a>

                                    </div>

                                </div>
                            </div>
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
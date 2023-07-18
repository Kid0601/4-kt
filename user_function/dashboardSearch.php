<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title
require_once("db_connect_small_project.php");


//分頁功能
$page = $_GET["page"] ?? 1;
$startItem = ($page - 1) * 10;
//修改功能連結

// //查詢會員資料庫
// $sql = "SELECT * FROM users WHERE valid=1 LIMIT $startItem,10 "; //LIMIT $startItem,10  <----加上自己的頁籤功能記得要加這個
// $result = $conn->query($sql);
// $rows = $result->fetch_all(MYSQLI_ASSOC);



//搜尋功能
$searchValue = $_GET['search'];
if (isset($searchValue)) {
    $searchResult = "SELECT * FROM users WHERE valid=1 AND( account LIKE '%$searchValue%' OR id LIKE '%$searchValue%' OR password LIKE'%$searchValue%' OR email LIKE '%$searchValue%') ";
    $result = $conn->query($searchResult);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
}

//計算總頁數
// $sqlPages = "SELECT * FROM users WHERE valid=1";
$resultTotalPages = $conn->query($searchResult);
$totalPages = $resultTotalPages->num_rows;
$pages = ceil($totalPages / 10); //計算總共有幾頁
$title = "搜尋結果:$searchValue";

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
                        <li class="breadcrumb-item active">搜尋結果</li>
                    </ol>
                    <div class="d-flex justify-content-between align-content-center py-1">
                        <ol class="breadcrumb ">
                            <li class="breadcrumb-item active">共計:<?= $totalPages; ?> 筆</li>
                        </ol>
                        <!-- 搜尋功能 -->
                        <!-- <form action="dashboardSearch.php" method='get'>
                            <input type="text" name="search">
                            <button class="btn btn-dark" type="submit">搜尋</button>
                        </form> -->
                    </div>
                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->

                        <div class="card-body">
                            <table class="table" id="datatablesSimple">
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
                                    <?php foreach ($rows as $users) :; ?>
                                        <tr>
                                            <td><?= $users["id"]  ?></td>
                                            <td><?= $users["account"]  ?></td>
                                            <td><?= $users["password"]  ?></td>
                                            <td><?= $users["email"]  ?></td>
                                            <td><?php
                                                if ($users["vip"] == 0) {
                                                    echo "普通會員";
                                                    echo "<img src='user0.svg' style='width:30px;' class='ms-2' alt=''>";
                                                } elseif ($users["vip"] == 1) {
                                                    echo "銀會員";
                                                    echo "<img src='user1.svg' style='width:30px;' class='ms-2' alt=''>";
                                                } elseif ($users["vip"] == 2) {
                                                    echo "金會員";
                                                    echo "<img src='user2.svg' style='width:30px;' class='ms-2' alt=''>";
                                                } else {
                                                    echo "怪東西";
                                                }
                                                ?>
                                                <!-- <img src="" alt=""> -->
                                            </td>
                                            <td>
                                                <a href="doRead.php?id=<?= $users["id"] ?>" class="btn btn-dark">Read</a>
                                                <a href="updateUserUI.php?id=<?= $users["id"] ?>" class="btn btn-dark">Update</a>
                                                <a href="doStop.php?id=<?= $users["id"] ?>" class="btn btn-dark">停權</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="operation py-3">
                        <h3>管理者操作面板</h3>
                        <div class="operation-content">
                            <a href="/key_traveler/user_function/dashboard.php"><button class="btn btn-dark">回到會員資料</button></a>

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
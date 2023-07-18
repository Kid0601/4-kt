<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title
$title = "會員列表";

require_once("db_connect_small_project.php");


//分頁功能
$page = $_GET["page"] ?? 1;
$startItem = ($page - 1) * 10;
//修改功能連結

//查詢會員資料庫
$sql = "SELECT * FROM users WHERE valid=1 LIMIT $startItem,10 "; //LIMIT $startItem,10  <----加上自己的頁籤功能記得要加這個
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

//計算總頁數
$sqlPages = "SELECT * FROM users WHERE valid=1";
$resultTotalPages = $conn->query($sqlPages);
$totalPages = $resultTotalPages->num_rows;
$pages = ceil($totalPages / 10); //計算總共有幾頁

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
                        <li class="breadcrumb-item active">會員列表</li>
                    </ol>
                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->
                        <div class="card-header d-flex align-item-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-table me-1  pe-2"></i>
                                <p class="my-0 pe-2">會員資料列表</p>
                                <p class="breadcrumb-item active my-0">共計:<?= $totalPages; ?> 筆</p>
                            </div>
                            <div class="searchbox">
                                <form action="dashboardSearch.php" method='get'>
                                    <input type="text" name="search">
                                    <button class="btn btn-dark" type="submit">搜尋</button>
                                </form>
                            </div>

                        </div>
                        <div class="card-body">
                            <!------------------------------------------------  輸入表格--------------------------------------------------------------->
                            <!-- id="datatablesSimple" 大絕 -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Account</th>
                                        <th>Password</th>
                                        <th>Email</th>
                                        <th>VIP</th>
                                        <th>Operation</th>
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
                    <!-- 會員資料頁籤 -->
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link text-dark " href="dashboard.php?page=<?= $page - 1 == 0 ? $page = 1 : $page - 1   ?>">Previous</a></li>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li class="page-item"><a class="page-link text-dark" href="dashboard.php?page=<?= $i ?>"><?= $i ?></a></li>
                            <?php endfor ?>
                            <li class="page-item"><a class="page-link text-dark" href="dashboard.php?page=<?= $page + 1 <= $pages ? $page + 1 : $page ?>">Next</a></li>
                        </ul>
                    </nav>
                    <!--       以上頁籤         -->
                    <div class="operation py-3 ">
                        <h3>管理者操作面板</h3>
                        <div class="operation-content">
                            <a href="/key_traveler/user_function/register.php"><button class="btn btn-dark">新增</button></a>
                            <a href="stopUser.php" class="btn btn-dark">停權名單</a>
                        </div>
                        <a href="register_back-end-test.php" class="text-light">新增_後端表單驗證(測試用) </a>
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
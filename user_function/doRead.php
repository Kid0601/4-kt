<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title
$title = "會員資料";

require_once("db_connect_small_project.php");
//user_profile
$sql = "SELECT * FROM user_profile";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
//user
$sqlUser = "SELECT * FROM users";
$resultUser = $conn->query($sqlUser);
$rowsUser = $resultUser->fetch_all(MYSQLI_ASSOC);

//讀取id
$id = $_GET["id"];
$idA = $_GET["id"] - 1;


//文章收藏功能
$titleWeb = $conn->query(
    "SELECT article_like.*,article.title FROM article_like
JOIN article ON article.id = article_like.article_id
WHERE article_like.user_id = $id"
);
$titles = $titleWeb->fetch_all(MYSQLI_ASSOC);
// var_dump($titles);


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
                        <li class="breadcrumb-item active">會員資料</li>
                    </ol>
                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->
                        <div class="card-body ">
                            <table class="table table-bordered  table-striped border-5  border-secondary rounded">
                                <tr class="row">
                                    <td class="col">Account</td>
                                    <td class="col"><?= $rowsUser[$idA]['account'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">Password</td>
                                    <td class="col"><?= $rowsUser[$idA]['password'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">Email</td>
                                    <td class="col"><?= $rowsUser[$idA]['email'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">Last Name</td>
                                    <td class="col"><?= $rows[$idA]['last_name'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">First Name</td>
                                    <td class="col"><?= $rows[$idA]['first_name'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">gender</td>
                                    <td class="col"><?= $rows[$idA]['gender'] == 1 ? "女" : "男" ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">birthday</td>
                                    <td class="col"><?= $rows[$idA]['birthday'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">phone</td>
                                    <td class="col"><?= $rows[$idA]['phone'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">address</td>
                                    <td class="col"><?= $rows[$idA]['address'] ?></td>
                                </tr>
                                <tr class="row">
                                    <td class="col">Created Time</td>
                                    <td class="col"><?= $rowsUser[$idA]['created_at'] ?></td>
                                </tr>
                            </table>
                            <div class="user_profile_box m-auto pt-5 w-100">
                                <h2>喜愛文章</h2>
                                <div class="border p-3 border-secondary border-3 rounded">
                                    <h4>
                                        <?php
                                        foreach ($titleWeb as $articleTitle) {
                                            echo '<a href="#" class="text-secondary"><li>' . $articleTitle["title"] . '</a><br>';
                                        }
                                        ?>
                                    </h4>
                                </div>

                            </div>
                            <a href="updateProfileUserUI.php?id=<?= $id ?>" class="btn btn-dark my-5 w-25 mx-auto">編輯</a>

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
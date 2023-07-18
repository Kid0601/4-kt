<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title
$title = "編輯會員";
require_once("db_connect_small_project.php");
// $sql = "SELECT * FROM user_profile";
// $result = $conn->query($sql);
// $rows = $result->fetch_all(MYSQLI_ASSOC);

$id = $_GET["id"];
$lastName = $_POST["lastName"];
$firstName = $_POST["firstName"];
$gender = $_POST["gender"];
$birthday = $_POST["birthday"];
$phone = $_POST["phone"];
$address = $_POST["address"];

// echo $id . '<br>', $lastName . '<br>', $firstName . '<br>', $gender . '<br>', $birthday . '<br>', $phone . '<br>', $address . '<br>';

$all = "UPDATE `user_profile` SET 
`last_name`='$lastName',`first_name`='$firstName',`gender`='$gender' ,`birthday`='$birthday',`phone`='$phone',`address`='$address' 
WHERE id=$id ";
$conn->query($all);


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
                        <li class="breadcrumb-item active">編輯會員</li>
                    </ol>
                    <div class="card mb-4">
                        <!-- 表格放卡片裡面 -->
                        <div class="card-body">
                            <div class="user_profile_box m-auto pt-5">
                                <h1>更新資料完成，資料如下:</h1>
                                <div class="border p-3 border-dark border-3 rounded">
                                    <h3>last Name:<?= $lastName ?></h3>
                                    <h3>First Name:<?= $firstName ?></h3>
                                    <h3>gender:<?= $gender == 1 ? "女" : "男"; ?></h3>
                                    <h3>birthday:<?= $birthday ?></h3>
                                    <h3>phone:<?= $phone ?></h3>
                                    <h3>address:<?= $address ?></h3>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small my-3"><a class="text-dark" href=" dashboard.php">Go to dashboard</a></div>
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
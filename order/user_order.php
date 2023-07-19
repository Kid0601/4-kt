<?php
require_once("../db_connect.php");

$whereClouse = "";

if (isset($_GET["start"])) {
    $start = $_GET["start"];
    $end = $_GET["end"];
    if($start=="")$start="2023-01-01";
    if($end=="")$end="2023-12-31";
    $whereClouse = "WHERE user_order.order_date BETWEEN '$start' AND '$end'";
}


$sql = "SELECT user_order.*, users.account AS user_account, user_profile.address
FROM user_order
JOIN users ON users.id=user_order.user_id
JOIN user_profile ON user_profile.user_id = user_order.user_id
$whereClouse
ORDER BY id ASC";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// 網頁 title
$title = "訂單列表";

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
                        <li class="breadcrumb-item active"><a href="user_order.php" class="text-decoration-none text-reset">訂單列表</a></li>
                    </ol>
                    
                    <div class="mb-3 d-flex">
                        <form action="user_order.php">
                            <div class="row">
                                <div class="col-auto">
                                    <input type="date" class="form-control" name="start" value="<?php if (isset($_GET["start"])) echo $_GET["start"] ?>">
                                </div>
                                <div class="col-auto">~</div>
                                <div class="col-auto">
                                    <input type="date" class="form-control" name="end" value="<?php if (isset($_GET["end"])) echo $_GET["end"] ?>">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-secondary" type="submit">搜尋</button>
                                </div>
                            </div>
                        </form>
                        <div class="ms-2">
                        <?php if (isset($_GET["start"])) : ?>
                            <a class="btn btn-secondary" href="user_order.php">回訂單列表</a>
                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>訂單編號</th>
                                        <th>會員帳號</th>
                                        <th>下單時間</th>
                                        <th>訂單狀態</th>
                                        <th>訂單分類</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row) : ?>
                                        <tr>
                                            <td><a class="btn btn-outline-dark" href="user_order_list.php?id=<?= $row["id"] ?>"><?= $row["id"] ?></a></td>
                                            <td><?= $row["user_account"] ?></td>
                                            <td><?= $row["order_date"] ?></td>
                                            <td>
                                                <?php
                                                // switch ($row["status"]) {
                                                //     case 0:
                                                //         $row["status"]= "待出貨";
                                                //         break;
                                                //     case 1:
                                                //         $row["status"]= "已出貨";
                                                //         break;
                                                //     case 2:
                                                //         $row["status"]= "已送達";
                                                //         break;
                                                //     case 3:
                                                //         $row["status"]= "已取貨";
                                                //         break;
                                                // }
                                                ?>                       
                                                <form action="doOrderEdit.php" method="post">
                                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                    <div class="d-flex">
                                                        <select name="status" class="form-control">
                                                            <?php                     
                                                            $status = [
                                                                "待出貨" => 0,
                                                                "已出貨" => 1,
                                                                "已送達" => 2,
                                                                "已取貨" => 3
                                                            ]
                                                            ?>
                                                            <?php foreach ($status as $ke => $v) : ?>
                                                                <option value="<?= $v ?>" <?php if ($row["status"] == $v) echo 'selected'; ?>><?= $ke ?></option>
                                                            <?php endforeach; ?>
                                                        </select>

                                                        <button class="btn btn-secondary ms-3 text-nowrap" type="submit">儲存</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <?php
                                                switch ($row["order_category"]) {
                                                    case 0:
                                                        echo "普通訂單";
                                                        break;
                                                    case 1:
                                                        echo "團購訂單";
                                                        break;
                                                    case 2:
                                                        echo "租用訂單";
                                                        break;
                                                }
                                                ?>
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
<?php
// ===== 要使用模板，記得注意路徑，否則抓不到template裡面的檔案 =====
// ===== 把模板複製到你的資料夾，然後修改裡面的內容就能用了 =====
// 網頁 title

$now = date("Y-m-d");

$title = "Discount";
$valid = $_GET["valid"] ?? "";
$page = $_GET["page"] ?? 1;
$type = $_GET["type"] ?? 0;
$member = $_GET["member"] ?? "";

require_once("../db_connect.php");
// $sql = "SELECT * FROM coupon";

$whereclouse = "";

if (isset($_GET["start"]) && isset($_GET["end"])) {
    $start = $_GET["start"] == "" ? '2023-01-01' : $_GET["start"];
    $end = $_GET["end"] == "" ? '2023-12-31' : $_GET["end"];
}



if ($member != "") {
    $whereclouse = "WHERE (vip_id=$member OR vip_id=3)";
    if ($valid != "") {
        $whereclouse .= " AND valid=$valid";
    }
    if (isset($_GET["start"]) && isset($_GET["end"])) {
        $whereclouse .= " AND (start_date BETWEEN '$start' AND '$end')";
    }
} else {
    if ($valid != "") {
        $whereclouse = "WHERE valid=$valid";
        if (isset($_GET["start"]) && isset($_GET["end"])) {
            $whereclouse .= " AND (start_date BETWEEN '$start' AND '$end')";
        }
    } else {
        if (isset($_GET["start"]) && isset($_GET["end"])) {
            $whereclouse = "WHERE start_date BETWEEN '$start' AND '$end'";
        }
    }
}



// $sqlTotal = "SELECT id FROM coupon WHERE valid=1";
$sqlTotal = "SELECT id FROM coupon $whereclouse";
$resultTotal = $conn->query($sqlTotal);
$totalCoupon = $resultTotal->num_rows;

$perPage = 5;
$startItem = ($page - 1) * $perPage;

// 總共頁數
$totalpage = ceil($totalCoupon / $perPage);

if ($type == 0) {
    $orderby = "ORDER BY id ASC";
} elseif ($type == 1) {
    $orderby = "ORDER BY vip_id ASC,id ASC";
} elseif ($type == 2) {
    $orderby = "ORDER BY vip_id DESC,id ASC";
} elseif ($type == 3) {
    $orderby = "ORDER BY start_date ASC,id ASC";
} elseif ($type == 4) {
    $orderby = "ORDER BY start_date DESC,id ASC";
} elseif ($type == 5) {
    $orderby = "ORDER BY id ASC";
} elseif ($type == 6) {
    $orderby = "ORDER BY id DESC";
} else {
    header("location: /404.php");
}

// $sqlvalid = "SELECT * FROM test_valid ORDER BY id ASC";
// $resultvalid = $conn->query($sqlvalid);
// $rows

// echo "type is $type";
//$sql = "SELECT * FROM coupon WHERE valid=1 $orderby LIMIT $startItem,$perPage";
$sql = "SELECT * FROM coupon $whereclouse $orderby LIMIT $startItem,$perPage";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
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
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <?php
                        //echo "date is $now <br>"; 
                        // echo "startItem is $startItem <br>";
                        // echo "sqlTotal is " . $sqlTotal;
                        // echo "<br>sql is " . $sql;
                        // echo "sql is " . $sql . "<br>";
                        // echo "Start is " . $start . ",End is" . $end . "<br>";
                        ?>
                        <h1>優惠券列表</h1>
                        <a href="coupon_create.php" class="btn btn-primary h-100">新增</a>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <!-- 你有幾層就複製幾個 -->
                            <li class="breadcrumb-item">
                                <?php if ($member != "") : ?>
                                    <a href="coupon_list.php" class="text-decoration-none">優惠券列表</a>
                                <?php else : ?>
                                    優惠券列表
                                <?php endif; ?>
                            </li>
                            <li class="breadcrumb-item active">
                                <?php
                                if ($member == 0)
                                    echo "一般會員";
                                else if ($member == 1)
                                    echo "銀會員";
                                else if ($member == 2)
                                    echo "金會員";
                                else
                                    echo "全部";
                                ?>
                            </li>
                        </ol>
                    </nav>
                    <div class="py-3 d-flex justify-content-between align-itens-center">
                        <ul class="nav nav-underline">
                            <li class="nav-item">
                                <a class="nav-link <?php if ($member == "") echo "active";
                                                    else echo "link-success" ?> " aria-current="page" href="coupon_list.php">全部</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link <?php //if ($valid == 1) echo "active"; 
                                                    ?>" href="coupon_list.php?valid=1">上架</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php //if ($valid == 0) echo "active"; 
                                                    ?>" href="coupon_list.php?valid=0">下架</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link <?php if ($member == 0) echo "active";
                                                    else echo "link-success" ?>" href="coupon_list.php?member=0">一般會員</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($member == 1) echo "active";
                                                    else echo "link-success" ?>" href="coupon_list.php?member=1">銀會員</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($member == 2) echo "active";
                                                    else echo "link-success" ?>" href="coupon_list.php?member=2">金會員</a>
                            </li>
                        </ul>
                        <div class="mt-1" id="check_valid">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="check_valid" id="check_valid1" value="1" onclick="location.href='coupon_list.php?member=<?= $member ?>'" <?php if ($valid == "") echo "checked" ?>>
                                <label class="form-check-label" for="check_valid1">全部</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="check_valid" id="check_valid2" value="1" onclick="location.href='coupon_list.php?valid=1&member=<?= $member ?>'" <?php if ($valid == 1) echo "checked" ?>>
                                <label class="form-check-label" for="check_valid2">上架中</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="check_valid" id="check_valid3" value="0" onclick="location.href='coupon_list.php?valid=0&member=<?= $member ?>'" <?php if ($valid == 0) echo "checked" ?>>
                                <label class="form-check-label" for="check_valid3">已下架</label>
                            </div>
                        </div>
                    </div>
                    <div class="py-3">
                        <form action="doSearch.php">
                            <div class="row gx-2">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="搜尋優惠券/折扣碼" name="name">
                                    <input type="hidden" class="form-control" name="member" value="<?= $member ?>">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-info" type="submit">搜尋</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <form action="coupon_list.php">
                            <div class="row align-items-center gx-2">
                                <div class="col-auto">
                                    開始日期區間
                                </div>
                                <div class="col-auto">
                                    <input type="date" class="form-control" name="start" value="<?php if (isset($_GET["start"])) echo $_GET["start"]; ?>">
                                </div>
                                <div class="col-auto">
                                    to
                                </div>
                                <div class="col-auto">
                                    <input type="date" class="form-control" name="end" value="<?php if (isset($_GET["end"])) echo $_GET["end"]; ?>">
                                </div>
                                <input type="hidden" value="<?= $member ?>" name="member">
                                <input type="hidden" value="<?= $valid ?>" name="valid">
                                <div class="col-auto">
                                    <button class="btn btn-info" type="submit">查詢</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="py-2 d-flex justify-content-end align-items-center">
                        <?php //echo "member is $member<br>"; 
                        ?>
                        <span class="text-center order">排序方式:</span>
                        <select name="order_type" id="order_type" class="form-select" style="width: 140px;">
                            <option value="" <?php if ($type == 0) echo "selected"; ?>></option>
                            <?php if ($member == "") : ?>
                                <option value="會員等級" class="order_grade" <?php if ($type == 1 || $type == 2) echo "selected"; ?>>會員等級</option>
                            <?php endif; ?>
                            <option value="開始日期" class="order_time" <?php if ($type == 3 || $type == 4) echo "selected"; ?>>開始日期</option>
                            <option value="優惠券編號" class="order_id" <?php if ($type == 5 || $type == 6) echo "selected"; ?>>優惠券編號</option>
                        </select>
                        <select name="order_grade" id="order_grade" class="<?php if ($type == 1 || $type == 2) echo "d-block";
                                                                            else echo "d-none"; ?> form-select ms-2" style="width: 120px;">
                            <option value="" <?php if ($type == 0) echo "selected"; ?>></option>
                            <option value="由低至高" id="order_type_1" <?php if ($type == 1) echo "selected"; ?>>由低至高</option>
                            <option value="由高至低" id="order_type_2" <?php if ($type == 2) echo "selected"; ?>>由高至低</option>
                        </select>
                        <select name="order_time" id="order_time" class="<?php if ($type == 3 || $type == 4) echo "d-block";
                                                                            else echo "d-none"; ?> form-select ms-2" style="width: 120px;">
                            <option value="" <?php if ($type == 0) echo "selected"; ?>></option>
                            <option value="由近至遠" id="order_type_3" <?php if ($type == 3) echo "selected"; ?>>由近至遠</option>
                            <option value="由遠至近" id="order_type_4" <?php if ($type == 4) echo "selected"; ?>>由遠至近</option>
                        </select>
                        <select name="order_id" id="order_id" class="<?php if ($type == 5 || $type == 6) echo "d-block";
                                                                        else echo "d-none"; ?> form-select ms-2" style="width: 120px;">
                            <option value="" <?php if ($type == 0) echo "selected"; ?>></option>
                            <option value="由低至高" id="order_type_5" <?php if ($type == 5) echo "selected"; ?>>由低至高</option>
                            <option value="由高至低" id="order_type_6" <?php if ($type == 6) echo "selected"; ?>>由高至低</option>
                        </select>
                        <a href="coupon_list.php?page=<?= $page ?>&type=0&member=<?= $member ?>&valid=<?= $valid ?>" role="button" class="btn btn-secondary ms-2 <?php if ($type == 0) echo "disabled"; ?>">
                            <i class="fa-solid fa-rotate-left"></i>
                            重置排序
                        </a>
                    </div>
                    <?php if ($totalCoupon != 0) : ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>編號</th>
                                    <th>狀態</th>
                                    <th>優惠券名稱/折扣碼</th>
                                    <th style="width: 25%;">優惠敘述</th>
                                    <th>適用會員</th>
                                    <!-- <th>消費門檻</th> -->
                                    <!-- <th>折扣</th> -->
                                    <th>開始日期</th>
                                    <th>結束日期</th>
                                    <th>剩餘時間</th>
                                    <th>動作</th>
                                </tr>
                            </thead>
                            <?php foreach ($rows as $coupon) : ?>
                                <div class="modal fade" id="removeModal_<?= $coupon["id"] ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="">訊息</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                $couponValid = $coupon["valid"] == 1 ? "確認下架" : "確認上架";
                                                $couponName = !empty($coupon["coupon_name"]) ? $coupon["coupon_name"] : $coupon["coupon_code"];
                                                $coupon_content = $couponValid . "\"" . $couponName . "\"?";
                                                echo $coupon_content;
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <?php if ($coupon["valid"] == 1) : ?>
                                                    <a href="doRemove.php?id=<?= $coupon["id"] ?>" class="btn btn-danger">確認</a>
                                                <?php else : ?>
                                                    <a href="doPuton.php?id=<?= $coupon["id"] ?>" class="btn btn-danger">確認</a>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteModal_<?= $coupon["id"] ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="">訊息</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <span>
                                                    <?php
                                                    $couponDelete = "確認刪除";
                                                    $couponName = !empty($coupon["coupon_name"]) ? $coupon["coupon_name"] : $coupon["coupon_code"];
                                                    $coupon_content = $couponDelete . "\"" . $couponName . "\"?";
                                                    echo $coupon_content;
                                                    ?>
                                                </span>
                                                <br>
                                                <span class="text-danger">*此動作無法復原</span>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="doDelete.php?id=<?= $coupon["id"] ?>" class="btn btn-danger">確認</a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <tbody>
                                    <tr>
                                        <td><?= $coupon["id"] ?></td>
                                        <td class="<?php echo $coupon["valid"] == 1 ? "": "text-danger"; ?>"><?php echo $coupon["valid"] == 1 ? "上架中": "已下架"; ?></td>
                                        <td>
                                            <a href="coupon_edit.php?id=<?= $coupon["id"] ?>" class="btn btn-outline-secondary btn-sm">
                                                <?php echo !empty($coupon["coupon_name"]) ? $coupon["coupon_name"] : $coupon["coupon_code"]; ?>
                                            </a>
                                        </td>
                                        <td style="width: 25%;"><?= $coupon["description"] ?></td>
                                        <td>
                                            <?php
                                            switch ($coupon["vip_id"]) {
                                                case 0:
                                                    echo "一般會員";
                                                    break;
                                                case 1:
                                                    echo "銀會員";
                                                    break;
                                                case 2:
                                                    echo "金會員";
                                                    break;
                                                case 3:
                                                    echo "全站";
                                                    break;
                                                default:
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <!-- <td>
                                <?php
                                //echo $coupon["threshold"] == 0 ? "無" : $coupon["threshold"] . "元";
                                ?>
                            </td>
                            <td>
                                <?php
                                // echo !empty($coupon["coupon_name"]) ? $coupon["discount_percent"] : $coupon["discount_value"]; 
                                // if ($coupon["discount_percent"] != 0) {
                                //     $discount = (1 - $coupon["discount_percent"]) * 100;
                                //     echo $discount . "%";
                                // } else {
                                //     $discount = $coupon['discount_value'];
                                //     echo $discount . "元";
                                // }

                                ?>
                            </td> -->
                                        <?php
                                        $time = $coupon["start_date"] != "0000-00-00 00:00:00" ? $coupon["start_date"] : "無";
                                        ?>
                                        <td>
                                            <?php
                                            echo $time;
                                            ?>
                                        </td>
                                        <td><?= $time == "無" ? "無" : $coupon["end_date"] ?></td>
                                        <td>
                                            <?php
                                            $curr_time = date("Y-m-d H:i:s");
                                            if ($time == "無") {
                                                echo "無限期";
                                            } else if (strtotime($curr_time) - strtotime($coupon["end_date"]) > 0) {
                                                echo "已過期";
                                            } else if (strtotime($curr_time) - strtotime($coupon["start_date"]) < 0) {
                                                echo "尚未開始";
                                            } else {
                                                // 確認起始時間，當前時間>優惠券起始日期，則剩餘時間為$coupon["end_date"]-$curr_time
                                                // $count_start_time = (strtotime($curr_time) - strtotime($coupon["start_date"])) > 0 ? $curr_time : $coupon["start_date"];
                                                $Duration = round((strtotime($coupon["end_date"]) - strtotime($curr_time)) / 86400);
                                                echo $Duration . "天";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div>
                                                <?php if ($coupon["valid"] == 1) : ?>
                                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#removeModal_<?= $coupon["id"] ?>" type="button">下架</button>
                                                <?php else : ?>
                                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#removeModal_<?= $coupon["id"] ?>" type="button">上架</button>
                                                <?php endif; ?>
                                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal_<?= $coupon["id"] ?>" type="button">刪除</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endforeach ?>
                        </table>
                        <div class="d-flex justify-content-between">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                                        <li class="page-item <?php if ($i == $page) echo "active"; ?>">
                                            <a class="page-link" href="coupon_list.php?page=<?= $i ?>&type=<?= $type ?>&member=<?= $member ?>&valid=<?= $valid ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor ?>
                                </ul>
                            </nav>
                            <div>共 <?= $totalCoupon ?> 筆,第<?= $page ?> 頁</div>
                        </div>
                        <!-- <div class="d-grid gap-2">
                <button class="btn btn-success" type="button">編輯</button>
            </div> -->
                    <?php else : ?>
                        <?php if ($valid == 1 || $valid == "") : ?>
                            <h5 class="text-danger py-2">尚無優惠券，請點擊右上方新增</h5>
                        <?php elseif ($valid == 0) : ?>
                            <h5 class="text-danger py-2">無下架優惠券</h5>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <?php include("../template/footerJs.php") ?>


    <script>
        const order_type = document.querySelector("#order_type");
        const order_grade = document.querySelector("#order_grade");
        const order_time = document.querySelector("#order_time");
        const order_id = document.querySelector("#order_id");

        const check_valid = document.querySelectorAll(".check_valid");

        // const valid_check = document.querySelector("#valid_check");
        // const invalid_check = document.querySelector("#invalid_check");


        order_type.addEventListener("change", function() {
            if (order_type.value == "會員等級") {
                order_grade.classList.remove("d-none");
                order_time.classList.remove("d-block");
                order_id.classList.remove("d-block");

                order_grade.classList.add("d-block");
                order_time.classList.add("d-none");
                order_id.classList.add("d-none");
            } else if (order_type.value == "開始日期") {
                order_time.classList.remove("d-none");
                order_grade.classList.remove("d-block");
                order_id.classList.remove("d-block");

                order_time.classList.add("d-block");
                order_grade.classList.add("d-none");
                order_id.classList.add("d-none");
            } else if (order_type.value == "優惠券編號") {
                order_id.classList.remove("d-none");
                order_time.classList.remove("d-block");
                order_grade.classList.remove("d-block");

                order_id.classList.add("d-block");
                order_time.classList.add("d-none");
                order_grade.classList.add("d-none");
            }
        });
        order_grade.addEventListener("change", function() {
            // console.log(order_grade);
            if (order_grade.value == "由低至高") {
                location.href = "coupon_list.php?type=1&member=<?= $member ?>&valid=<?= $valid ?>&start=<?=$start?>&end=<?=$end?>";
            } else if (order_grade.value == "由高至低") {
                location.href = "coupon_list.php?type=2&member=<?= $member ?>&valid=<?= $valid ?>&start=<?=$start?>&end=<?=$end?>";
            }

        });
        order_time.addEventListener("change", function() {
            // console.log(order_time);
            if (order_time.value == "由近至遠") {
                location.href = "coupon_list.php?type=3&member=<?= $member ?>&valid=<?= $valid ?>&start=<?=$start?>&end=<?=$end?>";
            } else if (order_time.value == "由遠至近") {
                location.href = "coupon_list.php?type=4&member=<?= $member ?>&valid=<?= $valid ?>&start=<?=$start?>&end=<?=$end?>";
            }
        });
        order_id.addEventListener("change", function() {
            // console.log(order_time);
            if (order_id.value == "由低至高") {
                location.href = "coupon_list.php?type=5&member=<?= $member ?>&valid=<?= $valid ?>&start=<?=$start?>&end=<?=$end?>";
            } else if (order_id.value == "由高至低") {
                location.href = "coupon_list.php?type=6&member=<?= $member ?>&valid=<?= $valid ?>&start=<?=$start?>&end=<?=$end?>";
            }
        });
    </script>
</body>

</html>
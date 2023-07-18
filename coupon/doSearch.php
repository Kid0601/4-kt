<?php

if (isset($_GET["name"])) {
    $name = $_GET["name"];
    $member = $_GET["member"] ?? "";
    $page = $_GET["page"] ?? 1;
    $type = $_GET["type"] ?? 0;


    require_once("../db_connect.php");

    // $sql = "SELECT * FROM coupon";
    $whereclouse = "WHERE (coupon.coupon_name LIKE '%$name%' OR coupon.coupon_code LIKE '%$name%')";
    if ($member != "") {
        $whereclouse .= " AND (coupon.vip_id=$member OR coupon.vip_id=3)";
    }

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
        $orderby = "ORDER BY vip_id ASC";
    } elseif ($type == 2) {
        $orderby = "ORDER BY vip_id DESC";
    } elseif ($type == 3) {
        $orderby = "ORDER BY start_date ASC";
    } elseif ($type == 4) {
        $orderby = "ORDER BY start_date DESC";
    } else {
        header("location: /404.php");
    }



    $sqlvip = "SELECT * FROM vip";
    $resultvip = $conn->query($sqlvip);
    $rowsvip = $resultvip->fetch_all(MYSQLI_ASSOC);


    $sql = "SELECT coupon.*, vip.vip_name AS vip_name FROM coupon JOIN vip ON vip.vip_id=coupon.vip_id $whereclouse $orderby LIMIT $startItem,$perPage";

    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $coupon_count = $result->num_rows;
} else {
    $coupon_count = 0;
}
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
                <div class="container-fluid px-4 pt-3">
                    <div class="py-2">
                        <a class="btn btn-success" href="coupon_list.php">
                            <i class="fa-solid fa-arrow-left"></i>
                            回優惠券列表
                        </a>
                    </div>
                    <div class="py-2">
                        <?php foreach ($rowsvip as $rowvip) : ?>
                            <?php if ($rowvip["vip_id"] == $member) : ?>
                                <span>
                                    <?php
                                    $resulttext = "";
                                    $resulttext .= "等級[" . $rowvip["vip_name"] . "]中,";
                                    $resulttext .= "搜尋\"";
                                    $resulttext .= $name;
                                    $resulttext .= "\"結果共 ";
                                    $resulttext .= "$totalCoupon 筆";
                                    echo $resulttext;
                                    ?>
                                </span>
                            <?php elseif ($member == "") : ?>
                                <span>
                                    <?php
                                    $resulttext = "";
                                    $resulttext .= "搜尋\"";
                                    $resulttext .= $name;
                                    $resulttext .= "\"結果共 ";
                                    $resulttext .= "$totalCoupon 筆";
                                    echo $resulttext;
                                    break;
                                    ?>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($totalCoupon != 0) : ?>
                        <div class="py-2 d-flex justify-content-end align-items-center">
                            <span class="text-center order">排序方式:</span>
                            <select name="order_type" id="order_type" class="form-select" style="width: 120px">
                                <option value="" <?php if ($type == 0) echo "selected"; ?>></option>
                                <option value="會員等級" class="order_grade" <?php if ($type == 1 || $type == 2) echo "selected"; ?>>會員等級</option>
                                <option value="開始日期" class="order_time" <?php if ($type == 3 || $type == 4) echo "selected"; ?>>開始日期</option>
                            </select>
                            <select name="order_grade" id="order_grade" class="<?php if ($type == 1 || $type == 2) echo "d-block";
                                                                                else echo "d-none"; ?> form-select ms-2" style="width: 120px">
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
                            <a href="doSearch.php?name=<?= $name ?>" role="button" class="btn btn-secondary ms-2 <?php if ($type == 0) echo "disabled"; ?>">
                                <i class="fa-solid fa-rotate-left"></i>
                                重置排序
                            </a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>編號</th>
                                    <th>優惠券名稱</th>
                                    <th style="width: 25%;">優惠敘述</th>
                                    <th>適用會員</th>
                                    <!-- <th>折扣門檻</th> -->
                                    <!-- <th>折扣</th> -->
                                    <th>開始日期</th>
                                    <th>結束日期</th>
                                    <th>剩餘時間</th>
                                    <th>下架/刪除</th>
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
                                        </td> -->
                                        <!-- <td>
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
                                            } else {
                                                // echo date("Y-m-d H:i:s")."<br>";

                                                // 確認起始時間，當前時間>優惠券起始日期，則剩餘
                                                $count_start_time = (strtotime($curr_time) - strtotime($coupon["start_date"])) > 0 ? $curr_time : $coupon["start_date"];
                                                $Duration = round((strtotime($coupon["end_date"]) - strtotime($count_start_time)) / 86400);
                                                echo $Duration . "天";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div>
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#removeModal_<?= $coupon["id"] ?>" type="button"><?php
                                                                                                                                                                        echo $coupon["valid"] == 1 ? "下架" : "上架";
                                                                                                                                                                        ?></button>
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
                                            <a class="page-link" href="doSearch.php?name=<?= $name ?>&page=<?= $i ?>&type=<?= $type ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor ?>
                                </ul>
                            </nav>
                            <div>共 <?= $totalCoupon ?> 筆,第<?= $page ?> 頁</div>
                        </div>
                    <?php else : ?>
                        <h5 class="text-danger py-2">無相關搜尋結果</h5>
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


        order_type.addEventListener("change", function() {
            if (order_type.value == "會員等級") {
                order_grade.classList.remove("d-none");
                order_time.classList.remove("d-block");

                order_grade.classList.add("d-block");
                order_time.classList.add("d-none");
            } else if (order_type.value == "開始日期") {
                order_time.classList.remove("d-none");
                order_grade.classList.remove("d-block");

                order_time.classList.add("d-block");
                order_grade.classList.add("d-none");
            }
        });
        order_grade.addEventListener("change", function() {
            console.log(order_grade);
            if (order_grade.value == "由低至高") {
                location.href = "doSearch.php?name=<?= $name ?>&type=1";
            } else if (order_grade.value == "由高至低") {
                location.href = "doSearch.php?name=<?= $name ?>&type=2";
            }

        });
        order_time.addEventListener("change", function() {
            console.log(order_time);
            if (order_time.value == "由近至遠") {
                location.href = "doSearch.php?name=<?= $name ?>&type=3";
            } else if (order_time.value == "由遠至近") {
                location.href = "doSearch.php?name=<?= $name ?>&type=4";
            }
        });
    </script>
</body>

</html>
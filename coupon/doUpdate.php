<!-- 此為更新優惠券內容檔案 -->
<?php
require_once("../db_connect_kt.php");
if (!isset($_POST["id"])) {
    die("請依正常管道");
}
$id = $_POST["id"];

if (!isset($_POST["membergrades"])) {
    echo "請選擇適用會員<br>";
    exit;
}
if (empty($_POST["coupon"])) {
    echo "請輸入優惠券名稱或折扣碼<br>";
    exit;
}

if (empty($_POST["description"])) {
    echo "清輸入優惠敘述<br>";
    exit;
}

if (!isset($_POST["threshold"])) {
    echo "請輸入消費門檻,若無請輸入0或無<br>";
    exit;
}

if (empty($_POST["discount_type"])) {
    echo "請選擇折扣種類<br>";
    exit;
}

if (empty($_POST["discount_percent"]) && empty($_POST["discount_value"])) {
    echo "請輸入折扣金額或百分比<br>";
    exit;
}

if (empty($_POST["start_date"]) || empty($_POST["end_date"]) || (strtotime($_POST["end_date"]) - strtotime($_POST["start_date"]) < 0)) {
    echo "請檢查日期<br>";
    exit;
}

require_once("../db_connect.php");

// echo $_POST["id"] . "[id]<br>";

// 會員等級
// echo $_POST["membergrades"] . "[grade]<br>";
// 優惠券/折扣碼名稱
// echo $_POST["discount_category"] . "[type_name]<br>";
// echo $_POST["coupon"] . "[type]<br>";
// 描述
// echo $_POST["description"] . "[description]<br>";
// 門檻
// echo $_POST["threshold"] . "[threshold]<br>";
// 百分比/金額
// echo $_POST["discount_type"] . "[discount_type]<br>";
// echo $_POST["discount_percent"] . "[discount_percent]<br>";
// echo $_POST["discount_value"] . "[discount_value]<br>";
// 日期
// echo $_POST["start_date"] . "[start_date]<br>";
// echo $_POST["end_date"] . "[end_date]<br>";

// 設定INSERT資料變數_S
switch ($_POST["membergrades"]) {
    case "1":
        $member = 0;
        break;
    case "2":
        $member = 1;
        break;
    case "3":
        $member = 2;
        break;
    case "4":
        $member = 3;
        break;
    default:
        break;
}



$coupon = $_POST["coupon"];

$description = $_POST["description"];

$threshold = $_POST["threshold"] == "無" ? 0 : $_POST["threshold"];


$discount_type = $_POST["discount_type"] == "percent" ? $_POST["discount_percent"] / 100 : $_POST["discount_value"];

$starttime = $_POST["start_date"];
$endtime = $_POST["end_date"];
// 設定INSERT資料變數_E

// 檢查會員等級與敘述及名稱是否不符_S
$sqlvip = "SELECT vip_id,vip_name FROM vip";
$resultvip = $conn->query($sqlvip);
$vipCount = $resultvip->num_rows;
$rowsvip = $resultvip->fetch_all(MYSQLI_ASSOC);
// var_dump($rowsvip);
// echo "<br>$vipCount";
for ($i = 0; $i < $vipCount; $i++) {
    // echo $i." ".$rowsvip[$i]["vip_id"]." ".$rowsvip[$i]["vip_name"]."member is $member"."<br>";
    if ($rowsvip[$i]["vip_id"] == $member) {
        if (strpos($description, $rowsvip[$i]["vip_name"]) !== False) {
            echo "選擇的是" . $rowsvip[$i]["vip_id"] . " " . $rowsvip[$i]["vip_name"] . "<br>";
            break;
        }
    } else {
        if (strpos($coupon, $rowsvip[$i]["vip_name"]) !== False || strpos($description, $rowsvip[$i]["vip_name"]) !== False) {
            echo "優惠名稱或敘述與適用會員不符合，請重新再試<br>";
            exit;
        }
    }
}
// 檢查會員等級與敘述及名稱是否不符_E

$text_per = '折';
$text_dol = '元';
$text_dis = '折扣';
$text_zero_thres = '不限金額';
$text_value_thres = '滿';

// 檢查門檻_S
$thres_s_idx = 0;
$thres_e_idx = 0;
$desdis_thres = "";
if (strpos($description, $text_zero_thres) !== False) {
    if ($threshold != '無' && $threshold != 0) {
        echo "優惠敘述與實際輸入門檻不同，請重新輸入";
        exit;
    }
} else {
    if (strpos($description, $text_value_thres) !== False && strpos($description, $text_dol) !== False) {
        $thres_s_idx = strpos($description, $text_value_thres) + 3;
        $thres_e_idx = strpos($description, $text_dol);
        for ($i = $thres_s_idx; $i < $thres_e_idx; $i++) {
            $desdis_thres .= $description[$i];
        }
        if ($desdis_thres != $threshold) {
            echo "優惠敘述與實際輸入門檻不同，請重新輸入";
            exit;
        }
    }
}


if (!is_numeric($_POST["threshold"])) {
    echo "消費門檻金額需為數字，請重新再試<br>";
    exit;
} else {
    if ($threshold % 100 != 0) {
        echo "消費門檻需為100的倍數，請重新再試<br>";
        exit;
    }
    if ($threshold < 0 || $threshold > 20000) {
        echo "消費門檻需介於0-20000，請重新再試<br>";
        exit;
    }
}
// 檢查門檻_E








// 檢查名稱、敘述、門檻、折扣
if ($_POST["discount_type"] == "price") {
    // 優惠敘述為百分比，實際輸入為金額_S
    if (strpos($description, $text_per) !== False && is_numeric($description[strpos($description, $text_per) - 1])) {
        echo "優惠敘述與折扣種類不同，請重新輸入";
        exit;
    } else {
        // 檢查折扣金額是否為10的倍數_S
        if ($discount_type % 10 != 0) {
            echo "折扣金額需為10的倍數<br>";
            exit;
        }
        // 檢查折扣金額是否為10的倍數_E

        $desdis_s_idx = 0;
        $desdis_e_idx = 0;
        $desdis_price = "";
        // 優惠敘述折扣金額與實際輸入金額不同_S
        $desdis_s_idx = strpos($description, $text_dis) + 6;
        $desdis_e_idx = strpos($description, $text_dol);

        for ($i = $desdis_s_idx; $i < $desdis_e_idx; $i++) {
            $desdis_price .= $description[$i];
        }
        if ($desdis_price != $discount_type) {
            echo "dis price is " . $desdis_price . ",input dis is" . $discount_type . "<br>";
            echo "優惠敘述折扣金額與實際輸入金額不同，請重新輸入";
            exit;
        }
        // 優惠敘述折扣金額與實際輸入金額不同_E
        // 名稱字串含有"折扣"&"元"
        if (strpos($coupon, $text_dis) !== False) {
            $desdis_price = "";
            $desdis_s_idx = strpos($coupon, $text_dis) + 6;
            if (strpos($coupon, $text_dis) !== False && strpos($coupon, $text_dol) !== False) {
                $desdis_e_idx = strpos($coupon, $text_dol);
            }
            // 名稱字串含有"折扣"
            else if (strpos($coupon, $text_dis) !== False) {
                $desdis_e_idx = strlen($coupon);
            }
            for ($i = $desdis_s_idx; $i < $desdis_e_idx; $i++) {
                $desdis_price .= $coupon[$i];
            }
            if ($desdis_price != $discount_type) {
                echo "dis price is " . $desdis_price . ",input dis is" . $discount_type . "<br>";
                echo "優惠名稱折扣金額與實際輸入金額不同，請重新輸入";
                exit;
            }
        }
    }
    // 優惠敘述為百分比，實際輸入為金額_E


} else {

    $d_per1 = 0;
    $d_per2 = 0;
    // 檢查折扣百分比是否與優惠敘述相符合_S
    if (strpos($description, $text_per)) {
        // echo $description[strpos($description, $text) - 2] . "match is " . strpos($description, '折') . "<br>";
        if (is_numeric($description[strpos($description, $text_per) - 1]) && is_numeric($description[strpos($description, $text_per) - 2])) {
            $d_per1 = $description[strpos($description, $text_per) - 2] * 10 + $description[strpos($description, $text_per) - 1];
        } else {
            if (is_numeric($description[strpos($description, $text_per) - 1])) {
                $d_per1 = $description[strpos($description, $text_per) - 1] * 10;
            } else {
                echo "優惠敘述需輸入折數<br>";
                exit;
            }
        }
        $d_per1 /= 100;
        echo $d_per1 . " " . $discount_type . "<br>";

        if ($d_per1 != $discount_type) {
            echo "優惠敘述需與折扣百分比相符合<br>";
            exit;
        }
    } else {
        echo "優惠敘述需輸入折數<br>";
        exit;
    }
    // 檢查折扣百分比是否與優惠敘述相符合_E

    // 檢查優惠名稱是否與優惠敘述相符合_S
    if ($_POST["discount_category"] == "ticket") {
        if (strpos($coupon, $text_per)) {
            if (is_numeric($coupon[strpos($coupon, $text_per) - 1]) && is_numeric($coupon[strpos($coupon, $text_per) - 2])) {
                $d_per2 = $coupon[strpos($coupon, $text_per) - 2] * 10 + $coupon[strpos($coupon, $text_per) - 1];
            } else {
                if (is_numeric($coupon[strpos($coupon, $text_per) - 1])) {
                    $d_per2 = $coupon[strpos($coupon, $text_per) - 1] * 10;
                } else {
                    echo "優惠名稱需輸入折數<br>";
                    exit;
                }
            }
            $d_per2 /= 100;
            echo $d_per2 . " " . $discount_type . "<br>";

            if ($d_per2 != $discount_type) {
                echo "優惠名稱需與折扣百分比相符合<br>";
                exit;
            }
        }
    }
}




// INSERT 資料
if ($_POST["discount_category"] == "ticket" && $_POST["discount_type"] == "percent") {
    $sql = "UPDATE coupon SET vip_id='$member' , coupon_name='$coupon' , description='$description' , threshold='$threshold' , discount_percent='$discount_type' , start_date='$starttime' , end_date='$endtime' WHERE id=$id";
} else if ($_POST["discount_category"] == "ticket" && $_POST["discount_type"] == "price") {
    $sql = "UPDATE coupon SET vip_id='$member' , coupon_name='$coupon' , description='$description' , threshold='$threshold' , discount_value='$discount_type' , start_date='$starttime' , end_date='$endtime' WHERE id=$id";
} else if ($_POST["discount_category"] == "code" && $_POST["discount_type"] == "percent") {
    $sql = "UPDATE coupon SET vip_id='$member' , coupon_code='$coupon' , description='$description' , threshold='$threshold' , discount_percent='$discount_type' , start_date='$starttime' , end_date='$endtime' WHERE id=$id";
} else {
    $sql = "UPDATE coupon SET vip_id='$member' , coupon_code='$coupon' , description='$description' , threshold='$threshold' , discount_value='$discount_type' , start_date='$starttime' , end_date='$endtime' WHERE id=$id";
}
// $sql = "UPDATE coupon SET vip_id='$' , coupon_name='$' , description='$' , threshold='$' , discount_percent='$' , start_date='$' , end_date='$' WHERE id=$id";

echo $sql;

if ($conn->query($sql) === TRUE) {
    $latestId = $conn->insert_id;
    echo "資料表 coupon 新增資料完成, id 為$latestId";
    header("location: coupon_edit.php?id=$id");
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();



?>
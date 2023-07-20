<?php

require_once("../db_connect.php");

$sql = "SELECT* FROM article "; // Add space at the end. Otherwise the SQL command will fail.
$title = "文章管理";

$page = $_GET["page"] ?? 1;
$sqlTotal = "SELECT id FROM article";
$resultTotal = $conn->query($sqlTotal);
$totalUser = $resultTotal->num_rows;

$perPage = 5;
$startItem = ($page - 1) * $perPage;

//計算總共頁數
$totalPage = ceil($totalUser / $perPage);

$type = $_GET["type"] ?? 1;
$orderBy = ""; // You need to declare it, otherwise it will be undefined outside if...else statement.
if ($type == 1) {
  $orderBy = "ORDER BY id ASC";
} elseif ($type == 2) {
  $orderBy = "ORDER BY id DESC";
} elseif ($type == 3) {
  $orderBy = "ORDER BY article_category ASC";
} elseif ($type == 4) {
  $orderBy = "ORDER BY article_category DESC";
} elseif ($type == 5) {
  $orderBy = "ORDER BY date ASC";
} elseif ($type == 6) {
  $orderBy = "ORDER BY date DESC";
} elseif ($type == 7) {
  $orderBy = "ORDER BY valid ASC";
} elseif ($type == 8) {
  $orderBy = "ORDER BY valid DESC";
}
//   elseif ($type == 9) {
//   $orderBy = "ORDER BY valid ASC";
// } elseif ($type == 10) {
//   $orderBy = "ORDER BY valid DESC";
// } 
else {
  echo "error about orderBy";
}

if (isset($_GET["type"])) {
  $sql = $sql . $orderBy;
}
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);


$sql_page = "SELECT* FROM article $orderBy LIMIT $startItem, $perPage";
$result_page = $conn->query($sql_page);
$rows = $result_page->fetch_all(MYSQLI_ASSOC);

// $sql_order = "SELECT* FROM article $orderBy";
// $result = $conn->query($sql);

// var_dump($rows[0]["title"]);
// for ($i = 0; $i < 8; $i++) {
//   var_dump($rows[$i]["title"]);
//   echo "<br>";
// }
// foreach ($rows as $row) {
//   var_dump($row["id"]);
//   echo "<br>";
// }




// $sqlLike = "SELECT user_like.*, users.name AS user_name FROM user_like 
// JOIN users ON user_like.user_id = users.id
// WHERE user_like.product_id = $id";

// $resultLike = $conn->query($sqlLike);
// $rowsLike = $resultLike->fetch_all(MYSQLI_ASSOC);


// $sqlImages = "SELECT * FROM product_images 
// WHERE product_id = '$id'
// ORDER BY id DESC";
// $resultImages = $conn->query($sqlImages);
// $productImages = $resultImages->fetch_all(MYSQLI_ASSOC);


// 
?>

<!doctype html>
<html lang="en">

<head>
  <title>article</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.3.0 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

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
            <li class="breadcrumb-item"></li>
            <li class="breadcrumb-item active">文章主頁</li>
          </ol>
          <div class="card mb-4">
            <!-- 表格放卡片裡面 -->
            <div class="card-body">
              <div class="container">
                <div class="py-2">
                  <form action="search_art.php">
                    <div class="row gx-2">
                      <div class="col">
                        <input type="text" class="form-control" placeholder="搜尋使用者" name="title">
                      </div>
                      <div class="col-auto">
                        <button class="btn btn-info" type="submit">搜尋</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div>
                  <a class="btn btn-info my-3" href="create_article.php">新增</a>
                </div>
                <!-- 排序 -->
                <div class="btn-group mb-2">
                  <a href="article.php?type=1&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type1>編號
                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                  </a>
                  <a href="article.php?type=2&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type2>編號
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                  </a>
                  <a href="article.php?type=3&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type3>分類
                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                  </a>
                  <a href="article.php?type=4&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type4>分類
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                  </a>
                  <a href="article.php?type=5&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type5>時間
                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                  </a>
                  <a href="article.php?type=6&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type6>時間
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                  </a>
                  <a href="article.php?type=7&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type7>狀態
                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                  </a>
                  <a href="article.php?type=8&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type8>狀態
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                  </a>
                  <!-- <a href="article.php?type=9&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type7>收藏數
                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                  </a>
                  <a href="article.php?type=10&page=<?= $page ?>" class="btn btn-secondary mx-1" id=type8>收藏數
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                  </a> -->
                </div>
                <!-- 資料表 -->
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>編號</th>
                      <th>標題</th>
                      <th>分類</th>
                      <th>發佈日期</th>
                      <th>狀態</th>
                      <th></th>
                      <th>收藏數</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // $key_values = array_column($rows, 'valid');
                    // array_multisort($key_values, SORT_ASC, $rows);
                    // 0715 2維array轉成json後印在console
                    // $js_code = 'console.log(' . json_encode($key_values) .
                    //   ');';
                    // $js_code = '<script>' . $js_code . '</script>';
                    // echo $js_code;

                    ?>
                    <!-- 欄位內容 -->
                    <?php foreach ($rows as $row) : ?>
                      <tr>
                        <td> <?= $row["id"] ?></td>
                        <td> <?= $row["title"] ?></td>
                        <td> <?php
                              $article_category = $row["article_category"];

                              switch ($article_category) {
                                case "0":
                                  echo "公告";
                                  break;
                                case "1":
                                  echo "開箱文";
                                  break;
                                case "2":
                                  echo "組裝教學";
                                  break;
                                case "3":
                                  echo "活動";
                                  break;
                              }; ?>
                        </td>
                        <td> <?= $row["date"] ?></td>
                        <td><?php
                            $valid = $row["valid"];

                            switch ($valid) {
                              case "0":
                                echo "下架";
                                break;
                              case "1":
                                echo "上架";
                                break;
                            }; ?>
                        </td>
                        <td>
                          <a href="art_read.php?id=<?= $row["id"] ?>" class="btn btn-info">檢閱&編輯</a>
                          <!-- 刪除功能 -->
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Modal<?= $row["id"] ?>">
                            刪除
                          </button>
                          <!-- modal -->
                          <div class="modal fade" id="Modal<?= $row["id"] ?>" tabindex="-1" aria-labelledby="<?= $row["id"] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="<?= $row["id"] ?>">確定刪除文章編號<?= $row["id"] ?>嗎?</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  注意! 無法復原編號<?= $row["id"] ?>文章
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                  <a href="doDelete_art.php?id=<?= $row["id"] ?>" class="btn btn-danger">刪除</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <!-- 收藏欄 -->
                        <td>
                          <?php
                          $total_like = "SELECT article_id, COUNT(*) as total_like FROM article_like group by article_id";
                          $result_like = $conn->query($total_like);
                          $rows_like = $result_like->fetch_all(MYSQLI_ASSOC);
                          foreach ($rows_like as $value) {
                            if ($row['id'] == $value['article_id']) {
                              echo $value['total_like'];
                            }
                          }
                          ?>
                        </td>

                      </tr>
                    <?php endforeach; ?>

                  </tbody>
                </table>
                <!-- 分頁button -->
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                      <li class="page-item">
                        <a class="page-link" href="article.php?page=<?= $i ?>&type=<?= $type ?>"><?= $i ?></a>
                      </li>
                    <?php endfor; ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- footer -->
      <?php include("../template/footer.php") ?>
    </div>
  </div>
  <?php include("../template/footerjs.php") ?>


  <script>
    // document.getElementById("type3").addEventListener("click", function() {
    //   $sql = "SELECT* FROM article order by valid";
    //   $result = $conn.query($sql);
    //   $rows = $result.fetch_all(MYSQLI_ASSOC);
    // });
  </script>

</body>

</html>
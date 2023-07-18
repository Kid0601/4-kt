<?php


require_once("../db_connect.php");

$sql = "SELECT* FROM article";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

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

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container">
    <div class="py-2">
      <form action="search.php">
        <div class="row gx-2">
          <div class="col">
            <input type="text" class="form-control" placeholder="搜尋使用者" name="name">
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
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>編號</th>
          <th>標題</th>
          <th>分類</th>
          <th>發佈日期</th>
          <th>狀態</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

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

              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#<?= $row["id"] ?>">
                刪除
              </button>
              <div class="modal fade" id="<?= $row["id"] ?>" tabindex="-1" aria-labelledby="<?= $row["id"] ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="<?= $row["id"] ?>">確定刪除欄位<?= $row["id"] ?>嗎?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      注意:無法復原文章<?= $row["id"] ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                      <a href="doDelete_art.php?id=<?= $row["id"] ?>" class="btn btn-danger">刪除</a>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script>

  </script>
</body>

</html>
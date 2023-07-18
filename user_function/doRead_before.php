<?php
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
$title = $conn->query(
    "SELECT article_like.*,article.title FROM article_like
JOIN article ON article.id = article_like.article_id
WHERE article_like.user_id = $id"
);
$titles = $title->fetch_all(MYSQLI_ASSOC);
// var_dump($titles);

?>
<!doctype html>
<html lang="en">

<head>
    <title>doRead</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="">

    <div class="container d-flex justify-content-center flex-column">
        <div class="w-100 bg-dark rounded py-3 mt-5"><a class="navbar-brand" href="index.html"> <img class="w-25 d-block mx-auto bg-dark " src="橫logo白.svg" alt=""></a></div>
        <div class="user_profile_box m-auto pt-5 w-100">
            <h1>資料如下:</h1>
            <div class="">
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
            </div>

        </div>
        <div class="user_profile_box m-auto pt-5 w-100">
            <h2>喜愛文章</h2>
            <div class="border p-3 border-secondary border-3 rounded">
                <h4>
                    <?php
                    foreach ($title as $articleTitle) {
                        echo '<a href="#" class="text-secondary"><li>' . $articleTitle["title"] . '</a><br>';
                    }
                    ?>
                </h4>
            </div>

        </div>
        <a href="updateProfileUserUI.php?id=<?= $id ?>" class="btn btn-dark my-5 w-25 mx-auto">編輯</a>

    </div>


</body>

</html>
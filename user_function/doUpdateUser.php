<?php
require_once("db_connect_small_project.php");
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$id = $_GET["id"];
$account = $_POST["account"];
$password = $_POST["password"];
$email = $_POST["email"];
$conn->query("UPDATE `users` SET `account`='$account',`password`='$password',`email`='$email' WHERE id=$id ");
// echo $id . '<br>', $account . '<br>', $password . '<br>', $email;
?>
<!doctype html>
<html lang="en">

<head>
    <title>doUpdate</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="bg-secondary">

    <div class="container d-flex justify-content-center flex-column">
        <a class="navbar-brand ps-3" href="index.html"> <img class="w-25 d-block mx-auto mt-3" src="橫logo白.svg" alt=""></a>
        <div class="user_profile_box m-auto pt-5">
            <h1>更新資料完成，資料如下:</h1>
            <div class="border p-3 border-body border-3 rounded">
                <h3>Account:<?= $account ?></h3>
                <h3>Password:<?= $password ?></h3>
                <h3>Email:<?= $email ?></h3>
            </div>
        </div>


        <div class="card-footer text-center py-3">
            <div class="small"><a href="dashboard.php" class="text-light">Go to dashboard</a></div>
        </div>
    </div>


</body>

</html>
<?php
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
<!doctype html>
<html lang="en">

<head>
    <title>doUpdateProfileUserUIr</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

    <div class="container d-flex justify-content-center flex-column">

        <div class="user_profile_box m-auto pt-5">
            <h1>更新資料完成，資料如下:</h1>
            <div class="border p-3 border-primary border-3 rounded">
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


</body>

</html>
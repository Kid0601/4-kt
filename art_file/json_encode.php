<?php
$img =  $_FILES['img'];
$imgs = $img["name"];

$arr_jsonData = [];
foreach ($imgs as $resutlts) {
    $jsonData = json_encode($resutlts);
    $arr_jsonData[] = $jsonData;
}
$jsonDataArrayString = implode(', ', $arr_jsonData);

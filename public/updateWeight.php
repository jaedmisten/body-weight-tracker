<?php
include('../config/connect.php');

if ($_POST['id'] && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST["dateTime"]) && $_POST["dateTime"] != "" && strtotime($_POST["dateTime"])) {
    $dateTime = $_POST["dateTime"];
    //echo "<p>dateTime: $dateTime</p>";
}
if (isset($_POST["weight"]) && is_numeric($_POST["weight"])) {
    $weight = $_POST["weight"];
    //echo "<p>weight: $weight</p>";
}

if (isset($id) && isset($dateTime) && isset($weight)) {
    try {
        $sql = 'UPDATE weights SET `weight` = ?, `date` = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        //print_r($stmt);
        //die();
        $result = $stmt->execute([$weight, $dateTime, $id]);
        echo $result;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
    }
} else {
    echo "VARIABLES NOT SET";
}




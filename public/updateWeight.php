<?php
include('../config/connect.php');

if ($_POST['id'] && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST["dateTime"]) && $_POST["dateTime"] != "" && strtotime($_POST["dateTime"])) {
    $dateTime = date('Y-m-d H:i:s', strtotime($_POST["dateTime"]));
}
if (isset($_POST["weight"]) && is_numeric($_POST["weight"])) {
    $weight = $_POST["weight"];
}

if (isset($id) && isset($dateTime) && isset($weight)) {
    try {
        $sql = 'UPDATE weights SET `weight` = ?, `date` = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$weight, $dateTime, $id]);
        echo $result;
    } catch (PDOException $e) {
        error_log("Error updating weight data.", 0);
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
        header('HTTP/1.1 500 Update Of Weight Record Failed');
    }
} else {
    header('HTTP/1.1 500 Incorrect Data');
}
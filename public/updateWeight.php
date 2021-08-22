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
        header('HTTP/1.1 500 Update Of Weight Record Failed');
    }
} else {
    echo "Incorrect data to insert. Will need to redirect to form with error.";
    header('HTTP/1.1 500 Incorrect Data');
}
<?php 
include('../config/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["dateTime"]) && $_POST["dateTime"] != "" && strtotime($_POST["dateTime"])) {
        $dateTime = date('Y-m-d H:i:s', strtotime($_POST["dateTime"]));
    }
    if (isset($_POST["weight"]) && is_numeric($_POST["weight"])) {
        $weight = $_POST["weight"];
    }
    if (isset($dateTime) && isset($weight)) {
        try {
            $sql = 'INSERT INTO weights (`weight`, `date`) VALUES (?, ?)';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$weight, $dateTime]);
        } catch (PDOException $e) {
            error_log("Error inserting new weight data.", 0);
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            header('HTTP/1.1 500 Insert Of Weight Record Failed');
        }
    } else {
        header('HTTP/1.1 500 Incorrect Data');
    }
}
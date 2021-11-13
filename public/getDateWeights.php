<?php
include('../config/connect.php');

if (isset($_POST["dateFrom"]) && $_POST["dateFrom"] != "" && strtotime($_POST["dateFrom"]) && isset($_POST["dateTo"]) && $_POST["dateTo"] != "" && strtotime($_POST["dateTo"])) {
    $dateFrom = date('Y-m-d H:i:s', strtotime($_POST["dateFrom"]));
    $dateTo = date('Y-m-d H:i:s', strtotime($_POST["dateTo"]));
    $orderByCol = $_POST["orderByCol"];
    $order = $_POST["order"];
    try {
        $sql = "SELECT * FROM weights WHERE date BETWEEN ? AND ? ORDER BY $orderByCol $order";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$dateFrom, $dateTo]);
        $weightRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($weightRows);
    } catch (PDOException $e) {
        error_log("Error inserting new weight data.", 0);
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
        header('HTTP/1.1 500 Retrieval Of Weight Records Failed');
    }
}


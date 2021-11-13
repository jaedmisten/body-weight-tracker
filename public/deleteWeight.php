<?php
include('../config/connect.php');

if ($_POST['id'] && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $sql = "DELETE FROM weights WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        echo $result;
    } catch (PDOException $e) {
        error_log("Error deleting weight record.", 0);
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
        header('HTTP/1.1 500 Deleting Weight Record Failed');
    }
}
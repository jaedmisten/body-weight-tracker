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
        echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
    }
}
<?php
include('../config/connect.php');

if ($_POST['id'] && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    //echo $id;
    //die();
    try {
        $sql = "SELECT * FROM weights WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $weightRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        /*
        echo  '<pre>';
        print_r($weightRow);
        echo '</pre>';
        */
        echo json_encode($weightRow);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
    }
}


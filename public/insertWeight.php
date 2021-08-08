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
            if ($result) {
                header('Location: viewWeights.php');
            } else {
                echo "THERE WAS AN ERROR INSERTING WEIGHT";
            }
        } catch (PDOException $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
            echo $e->getMessage();
            header('HTTP/1.1 500 Insert Of Weight Record Failed');
        }
    } else {
        echo "Incorrect data to insert. Will need to redirect to form with error.";
        header('HTTP/1.1 500 Incorrect Data');
    }
}


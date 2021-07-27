<?php 
include('../config/connect.php');
/*
echo '<pre>';
print_r($_SERVER);
echo '</pre>';
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<p>POSTED</p>";

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    //die();

    if (isset($_POST["dateTime"]) && $_POST["dateTime"] != "" && strtotime($_POST["dateTime"])) {
        $dateTime = $_POST["dateTime"];
        echo "<p>dateTime: $dateTime</p>";
    }
    if (isset($_POST["weight"]) && is_numeric($_POST["weight"])) {
        $weight = $_POST["weight"];
        echo "<p>weight: $weight</p>";
    }
    if (isset($dateTime) && isset($weight)) {
        try {
            $sql = 'INSERT INTO weights (`weight`, `date`) VALUES (?, ?)';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$weight, $dateTime]);
            echo '<pre>';
            print_r($result);
            echo '</pre>';

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
        echo "incorrect data to insert. Will need to redirect to form with error.";
        header('HTTP/1.1 500 Incorrect Data');
    }
}


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Body Weight Tracker</title>
    <!-- jQuery -->
    <script src="../js/dist/jquery.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../js/dist/bootstrap.css">
    <script src="../js/dist/bootstrap.js"></script>
    <!-- jquery-datetimepicker stylesheet-->
    <link rel="stylesheet" href="../js/dist/jquery.datetimepicker.css">
    <!-- jquery-datetimepicker -->
    <script src="../js/dist/jquery.datetimepicker.full.js"></script>
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- custom stylesheet -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" type="image/jpg" href="../img/favicon/favicon.png"/>
</head>

<body>
<div class="container">
    <div class="row header">
        <div class="col-md-6 offset-md-3" >
            <h1 class="center"><a class="site-title" href="/views/home.php">Body Weight Tracker</a></h1>
        </div>
    </div>
    <br>
    <div class="row center">
        <div class="col-md-2 offset-md-3"><a type="button" id="viewWeightsBtn" class="btn btn-primary gradient" href="/views/viewWeights.php">View Weights</a></div>
        <div class="col-md-2"><a type="button" id="addWeightBtn" class="btn btn-primary gradient" href="/views/addWeightForm.php">Add Weight</a></div>
        <div class="col-md-2"><a type="button" id="statsBtn" class="btn btn-primary gradient" href="/views/stats.php">Statistics</a></div>
    </div>

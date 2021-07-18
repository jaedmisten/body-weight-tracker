<?php include('../config/connect.php') ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Body Weight Tracker</title>
    <!-- jQuery -->
    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <!-- custom stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
<div class="container">
<div class="row" style="border: 1px solid red;">
    <div class="col-md-6 offset-md-3" style="border: 1px solid black;">
        <h1><a href="index.php">Body Weight Tracker</a></h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-3 offset-md-3"><a type="button" class="btn btn-success" href="viewWeights.php">View Weights</a></div>
    <div class="col-md-3"><a type="button" class="btn btn-success" href="addWeightForm.php">Add Weight</a></div>
</div>

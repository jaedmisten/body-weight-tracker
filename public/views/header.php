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
</head>

<body>
<div class="container">
<div class="row">
    <h1><a href="index.php">Body Weight Tracker</a></h1>
</div>
<div class="row">
<div class="col-md-offset-2 col-md-8">
    <div class="col"><a type="button" class="btn btn-success" href="viewWeights.php">View Weights</a></div>
    <div class="col"><a type="button" class="btn btn-success" href="addWeight.php">Add Weight</a></div>
</div>
</div>

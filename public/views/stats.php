<?php include('../../config/connect.php') ?>
<?php include('header.php') ?>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2 class="page-header">Body Weight Statistics</h2>
    </div>
</div>
<?php
try {
    if (!empty($_GET['orderByCol']) && (strtolower($_GET['orderByCol']) == 'date' || strtolower($_GET['orderByCol']) == 'weight')) {
        $orderByCol = $_GET['orderByCol'];
    } else {
        $orderByCol = 'date';
    }
    if (!empty($_GET['order']) && (strtolower($_GET['order']) == 'asc' || strtolower($_GET['order']) == 'desc')) {
        $order = $_GET['order'];
    } else {
        $order = 'DESC';
    }
    $sql = 'SELECT * FROM weights ORDER BY ' . $orderByCol . ' ' . $order;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $weights = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get average
    $total = 0;
    for($i = 0; $i < count($weights); $i++) {
        $total += $weights[$i]['weight'];
    }
    $avg = $total / count($weights);

    // Get standard deviation
    $deviationTotal = 0;
    for ($i = 0; $i < count($weights); $i++) {
        $deviationTotal += pow($weights[$i]['weight'], 2);
    }
    $standardDeviation = sqrt($deviationTotal / count($weights));
} catch (PDOException $e) {
    error_log("Error retrieving view weights data.", 0);
    error_log($e->getMessage());
    error_log($e->getTraceAsString());
}
?>
<div class="row">
    <div class="col-md-4 offset-md-4">
        <p>Average Weight: <?php echo $avg; ?><br>Standard Deviation: <?php echo round($standardDeviation, 4); ?></p>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#statsBtn').css('text-decoration', 'underline');
});
</script>
<?php include('footer.php') ?>
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

    // Get average, lowest weight, and highest weight.
    $total = 0;
    $lowWeight = $weights[0];
    $highWeight = $weights[0];
    for($i = 0; $i < count($weights); $i++) {
        $total += $weights[$i]['weight'];
        if ($weights[$i]['weight'] < $lowWeight['weight']) {
            $lowWeight = $weights[$i];
        }
        if ($weights[$i]['weight'] > $highWeight['weight']) {
            $highWeight = $weights[$i];
        }
    }
    $avg = $total / count($weights);

    // Get standard deviation
    $deviationTotal = 0;
    for ($i = 0; $i < count($weights); $i++) {
        $deviationTotal += pow($weights[$i]['weight'] - $avg, 2);
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
        <p>
            Average Weight: <?php echo $avg; ?>
            <br>Standard Deviation: <?php echo round($standardDeviation, 4); ?>
            <br>Lowest Weight: <?php echo $lowWeight['weight'] . ' lbs on ' . $lowWeight['date']; ?>
            <br>Highest Weight: <?php echo $highWeight['weight'] . ' lbs on ' . $highWeight['date']; ?>
        </p>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#statsBtn').css('text-decoration', 'underline');
});
</script>
<?php include('footer.php') ?>
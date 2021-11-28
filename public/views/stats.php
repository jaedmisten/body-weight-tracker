<?php include('../../config/connect.php') ?>
<?php include('header.php') ?>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2 class="page-header">Body Weight Statistics</h2>
    </div>
</div>
<?php
try {
    $sql = 'SELECT * FROM weights';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $weights = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($weights) >= 3) {
        // Get average, lowest weight, highest weight, and mode.
        $total = 0;
        $lowWeight = $weights[0];
        $highWeight = $weights[0];
        $out = [];
        for($i = 0; $i < count($weights); $i++) {
            $total += $weights[$i]['weight'];
            if ($weights[$i]['weight'] < $lowWeight['weight']) {
                $lowWeight = $weights[$i];
            }
            if ($weights[$i]['weight'] > $highWeight['weight']) {
                $highWeight = $weights[$i];
            }
            $out[] = $weights[$i]['weight'];
        }
        $avg = $total / count($weights);
        $weightCounts = array_count_values($out);
        arsort($weightCounts);
        if ($weightCounts[array_key_first($weightCounts)] > 1) {
            $mode = array_key_first($weightCounts);
        }

        // Get standard deviation
        $deviationTotal = 0;
        for ($i = 0; $i < count($weights); $i++) {
            $deviationTotal += pow($weights[$i]['weight'] - $avg, 2);
        }
        $standardDeviation = sqrt($deviationTotal / count($weights));
    }   
} catch (PDOException $e) {
    error_log("Error retrieving view weights data.", 0);
    error_log($e->getMessage());
    error_log($e->getTraceAsString());
}
?>
<?php if (count($weights) < 3): ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p class="empty-weights-msg">
                There <?php echo (count($weights) == 1) ? "is" : "are" ?> currently <?php echo count($weights); ?> weight record<?php if(count($weights) != 1) echo "s"; ?>.<br>
                There needs to be at least 3 weight records to display statistics.<br>
                Please click the Add Weight button to submit a weight record.
            </p>
        </div>
    </div>
<?php else: ?>
<div class="row">
    <div class="col-md-6 offset-md-4">
        <table id="statsTable">
            <tr>
                <td class="statsTableTdTitle">Average:&nbsp;</td>
                <td class="statsTableTdStat"><?php echo round($avg, 2) ?></td>
            </tr>
            <tr>
                <td class="statsTableTdTitle">Standard Deviation:&nbsp;</td>
                <td class="statsTableTdStat"><?php echo round($standardDeviation, 4); ?></td>
            </tr>
            <tr>
                <td class="statsTableTdTitle">Lowest Weight:&nbsp;</td>
                <td class="statsTableTdStat"><?php echo $lowWeight['weight'] . ' lbs on ' . date("m/d/Y H:i", strtotime($lowWeight['date'])); ?></td>
            </tr>
            <tr>
                <td class="statsTableTdTitle">Highest Weight:&nbsp;</td>
                <td class="statsTableTdStat"><?php echo $highWeight['weight'] . ' lbs on ' . date("m/d/Y H:i", strtotime($highWeight['date'])); ?></td>
            </tr>
            <?php if(isset($mode)): ?>
            <tr>
                <td class="statsTableTdTitle">Mode:&nbsp;</td>
                <td class="statsTableTdStat"><?php echo $mode; ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<?php endif; ?>
<script>
$(document).ready(function() {
    $('#statsBtn').css('text-decoration', 'underline');
});
</script>
<?php include('footer.php') ?>
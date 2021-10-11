<?php include('../../config/connect.php') ?>
<?php include('header.php') ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2 class="page-header">View Weight Records</h2>
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
} catch (PDOException $e) {
    var_dump($e);
    echo $e->getMessage();
}
?>
<?php if (empty($weights)): ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p class="empty-weights-msg">There are currently no weight records to display.<br>Please click the Add Weight button to submit a weight record.</p>
        </div>
    </div>
<?php  else: ?>
    <?php if (count($weights) >= 5): ?>
        <div class="row">
            <div class="col-md-8 offset-md-2 center">
                <a id="toggle-chart-link" href="#">Hide Chart</a>
            </div>
            <div id="chart-div" class="col-md-8 offset-md-2">
                From: <input type="text" id="fromDatetimepicker" class="form-control" name="dateTime" value="">
                
                To: <input type="text" id="toDatetimepicker" class="form-control" name="dateTime" value="">
                
                <a id="updateGraph" type="button" class="btn btn-info">Get Results</a>
                <div id="curve_chart" style="width: 900px; height: 500px"></div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <p class="charts-msg">A line chart will be available when there is a least five weight records.</p>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <br>
            <table id="weights-table" class="table table-bordered table-striped table-sm" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"><?php if ($orderByCol == 'date') $order = (strtolower($order) == 'desc') ? 'ASC' : 'DESC'; ?><a class="header-link" href="/views/viewWeights.php?orderByCol=date&order=<?php echo $order; ?>">Date <?php if ($orderByCol == 'date') echo (strtolower($order) == 'asc') ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>'; ?></a></th>
                        <th scope="col"><?php if ($orderByCol == 'weight') $order; ?><?php $order = (strtolower($order) == 'desc') ? 'ASC' : 'DESC'; ?><a class="header-link" href="/views/viewWeights.php?orderByCol=weight&order=<?php echo $order; ?>">Weight <?php if ($orderByCol == 'weight') echo (strtolower($order) == 'asc') ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-up"></i>'; ?></a></th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <?php foreach($weights as $weight): ?>           
                <tr id="table-row-<?php echo $weight["id"] ?>">          
                    <td class="td-date"><?php echo date("m/d/Y H:i", strtotime($weight["date"])); ?></td>
                    <td class="td-weight"><?php echo $weight["weight"]; ?></td>
                    <td>
                        <a id="edit-button-<?php echo $weight["id"] ?>" type="button" class="btn btn-info" data-id="<?php echo $weight["id"]; ?>" data-date="<?php echo date("m/d/Y H:i", strtotime($weight["date"])); ?>" data-weight="<?php echo $weight["weight"]; ?>"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;
                        <a id="delete-button-<?php echo $weight["id"] ?>" type="button" class="btn btn-danger" data-id="<?php echo $weight["id"]; ?>" data-date="<?php echo date("m/d/Y H:i", strtotime($weight["date"])); ?>" data-weight="<?php echo $weight["weight"]; ?>"><i class="far fa-trash-alt"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>       

<!-- Delete weight confirmation modal -->
<div class="modal fade" id="deleteWeightModal" tabindex="-1" aria-labelledby="deleteWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteWeightModalLabel">Delete Weight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this weight?
                    <br><br>
                    Date: <span class="date"></span>
                    <br>
                    Weight: <span class="weight"></span>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="deleteConfirm" type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Success deleting weight modal -->
<div class="modal fade" id="weightDeletedModal" tabindex="-1" aria-labelledby="weightDeletedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="weightDeletedModalLabel">Recorded Weight Deleted</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The recorded weight was successfully deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="weightDeletedModalClose" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Error deleting weight modal -->
<div class="modal fade" id="errorDeletingWeightModal" tabindex="-1" aria-labelledby="errorDeletingWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorDeletingWeightModalLabel">Error Deleting Weight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="error-msg">There was an error deleting the recorded weight.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="errorDeletingWeightModalClose" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit weight modal -->
<div class="modal fade" id="editWeightModal" tabindex="-1" aria-labelledby="editWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWeightModalLabel">Edit Weight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>To edit this weight record, update the appropriate fields and then click the Submit button.
                    <br>
                    <div class="row mb-3">
                        <label for="datetimepicker" class="col-sm-8 col-form-label">Date and Time (YYYY/MM/DD HH:MM):</label>
                        <div class="col-sm-10">
                            <input type="text" id="datetimepicker" class="form-control datetime" name="dateTime" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="weight" class="col-sm-3 col-form-label">Weight (LBS)</label>
                        <div class="col-sm-10">
                            <input type="number" id="weightInput" step=".1" class="form-control weight" name="weight" value="">
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button id="editSubmit" type="button" class="btn btn-primary"><i class="far fa-edit"></i> Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Success editing weight modal -->
<div class="modal fade" id="weightEditedModal" tabindex="-1" aria-labelledby="weightEditedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="weightEditedModalLabel">Recorded Weight Updated</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The recorded weight of<br>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Date/Time:</strong> <span id="oldDateTime"></span><br>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Weight:</strong> <span id="oldWeight"></span></p>
                <p>Has been updated to<br>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Date/Time:</strong> <span id="updatedDateTime"></span><br>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Weight:</strong> <span id="updatedWeight"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="weightEditedModalClose" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Error editing weight modal -->
<div class="modal fade" id="errorEditingWeightModal" tabindex="-1" aria-labelledby="errorEditingWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorEditingWeightModalLabel">Error Updating Weight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="error-msg">There was an error updating the recorded weight.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="errorEditingWeightModalClose" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
// Declare global javascript variables.
let weightObjects = <?php echo json_encode($weights); ?>;
let orderByCol = '<?php echo $orderByCol; ?>';
let order = '<?php echo $order; ?>';
</script>
<script src="../js/viewWeights.js"></script>
<script type="text/javascript">
function loadChart(weights) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(weights);

        var options = {
            title: 'Weights By Date',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
}
</script>
<script>
jQuery(document).ready(function () {
	'use strict';

    // Get first used date for weight record.
    let date = '';
    if (orderByCol == 'date' && order.toLowerCase() == 'asc') {
        date = weightObjects[0]['date'];
    } else if (orderByCol == 'date' && order.toLowerCase() == 'desc') {
        date = weightObjects[weightObjects.length - 1]['date'];
    } else {
        weightObjects.sort(function(a, b) {
            return a['date'] > b['date'] ? 1 : -1;
        });
        date = weightObjects[0]['date'];
    }

    // Date time pickers for line chart.
	jQuery('#fromDatetimepicker').datetimepicker({
        minDate: date,
        maxDate: '+1970/01/01',
        format: 'm/d/Y'
    });

    jQuery('#toDatetimepicker').datetimepicker({
        minDate: date,
        maxDate: '+1970/01/01',
        format: 'm/d/Y'
    });
});
</script>
<script>
// Date time picker for edit weight modal.
jQuery(document).ready(function () {
	'use strict';

	jQuery('#datetimepicker').datetimepicker({
        maxDate: '+1970/01/01',
        format: 'm/d/Y H:i'
    });
});
</script>
<?php include('footer.php') ?>
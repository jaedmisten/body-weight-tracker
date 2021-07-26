<?php include('../config/connect.php') ?>
<?php include('header.php') ?>
<br><br><br>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <?php
        try {
            $sql = 'SELECT * FROM weights ORDER BY date DESC';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $weights = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            var_dump($e);
            echo $e->getMessage();
        }
        ?>

        <table id="weights-table" style="width:100%">
            <tr>
                <th>Date</th>
                <th>Weight</th>
                <th>Actions</th>
            </tr>
            <?php foreach($weights as $weight) : ?>           
            </tr>          
                <td><?php echo $weight["date"] ?></td>
                <td><?php echo $weight["weight"] ?></td>
                <td>
                    <a type="button" class="btn btn-info" href="">Edit</a>&nbsp;&nbsp;
                    <a type="button" class="btn btn-danger" data-id="<?php echo $weight["id"]; ?>" data-date="<?php echo $weight["date"]; ?>" data-weight="<?php echo $weight["weight"]; ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>

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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="deleteConfirm" type="button" class="btn btn-warning">Delete</button>
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
    </div>
</div>

<script>
$('.btn-danger').click(function() {
    console.log('Delete button clicked');
    console.log(this);
    console.dir(this)
    let id = $(this).data('id');
    console.log('id: ', id);
    let date = $(this).data('date');
    let weight = $(this).data('weight');

    $('#deleteWeightModal .modal-body .date').html(date);
    $('#deleteWeightModal .modal-body .weight').html(weight);

    $('#deleteWeightModal').modal('show');

    $('#deleteConfirm').click(function() {
        console.log('%c#deleteWeightConfirm button clicked', 'font-size:14px;color:red;font-weight:bold;');
        console.log('id: ', id);

        $.ajax({
            url: 'deleteWeight.php',
            type: 'post',
            data: {id: id},
            success: function (response) {
                console.log("response: ", response);
                $('#deleteWeightModal').modal('hide');
                $('#weightDeletedModal').modal('show');
            }
        });
    });
});

$('#weightDeletedModalClose').click(function() {
    location.reload();
});
</script>

<?php include('footer.php') ?>
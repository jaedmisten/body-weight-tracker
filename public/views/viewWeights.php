<?php include('../../config/connect.php') ?>
<?php include('header.php') ?>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2 class="page-header">View Weight Records</h2>
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
        <?php if (empty($weights)): ?>
        <p class="empty-weights-msg">There are currently no weight records to display.<br>Please click the Add Weight button to submit a weight record.</p>
        <?php  else: ?>
        <table id="weights-table" class="table table-bordered table-striped table-sm" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Weight</th>
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
            <?php endforeach ?>
        </table>
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
    </div>
</div>
<script src="../js/viewWeights.js"></script>
<?php include('footer.php') ?>
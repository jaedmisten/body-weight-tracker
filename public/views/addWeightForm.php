<?php include('header.php') ?>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2 class="page-header">Add Weight Record</h2>
        <form>
            <div class="row mb-3">
                <label for="datetimepicker" class="col-sm-8 col-form-label">Date and Time (YYYY/MM/DD HH:MM):</label>
                <div class="col-sm-10">
                    <input type="text" id="datetimepicker" class="form-control" name="dateTime" value="">
                </div>
            </div>
            <div class="row mb-3">
                <label for="weight" class="col-sm-3 col-form-label">Weight (LBS)</label>
                <div class="col-sm-10">
                    <input type="number" id="weight" step=".1" class="form-control" name="weight" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <input type="submit" id="submit" class="btn btn-primary" name="submit">
                </div>
            </div>
        </form>
    </div> 
</div>
<script src="../js/addWeightForm.js"></script>
<?php include('footer.php') ?>
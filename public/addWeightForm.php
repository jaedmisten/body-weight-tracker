<?php include('header.php') ?>
<br><br><br>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="insertWeight.php" method="post">
            <div class="row mb-3">
                <label for="datetimepicker" class="col-sm-8 col-form-label">Date and Time (YYYY/MM/DD HH:MM):</label>
                <div class="col-sm-10">
                    <input type="text" id="datetimepicker" class="form-control" name="dateTime" value="">
                </div>
            </div>
            <div class="row mb-3">
                <label for="weight" class="col-sm-3 col-form-label">Weight (LBS)</label>
                <div class="col-sm-10">
                    <input type="number" step=".1" class="form-control" id="weight" name="weight" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <input type="submit" class="btn btn-primary" id="submit" name="submit">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#submit').prop('disabled', true);

    $('#weight').on('input', function() {
        let weight = this.value;
        let date = $('#datetimepicker').val()
        verifyInput(date, weight);
    });

    $('#datetimepicker').on('input', function() {
        let date = this.value;
        let weight = $('#weight').val();
        verifyInput(date, weight);
    });

    $('#datetimepicker').on('change', function() {
        let date = this.value;
        let weight = $('#weight').val();
        verifyInput(date, weight);
    });

    function verifyInput(date, weight) {
        console.log('verifyInput called');
        if (!isNaN(weight) && weight != "" && new Date(date) != "Invalid Date") {
            $('#submit').prop('disabled', false);
        } else {
            $('#submit').prop('disabled', true);
        }
    }
});
</script>

<?php include('footer.php') ?>
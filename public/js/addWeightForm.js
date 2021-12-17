$(document).ready(function() {
    $('#addWeightBtn').css('text-decoration', 'underline');

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
        if (isNaN(weight) || weight == "" || weight <= 0 || new Date(date) == "Invalid Date") {
            $('#submit').prop('disabled', true);
        } else {
            $('#submit').prop('disabled', false);
        }
    }

    $('#submit').click(function(e) {
        e.preventDefault();
        let dateTime = $('#datetimepicker').val();
        let weight = $('#weight').val();

        $.ajax({
            url: '../insertWeight.php',
            type: 'post',
            data: {dateTime: dateTime, weight: weight},
            success: function (response) {
                window.location.replace('/views/viewWeights.php');
            },
            error: function (response) {
                $('.add-weight-error-msg').html("There was an error inserting this weight record. Please check the input.");
            }
        });
    });
});
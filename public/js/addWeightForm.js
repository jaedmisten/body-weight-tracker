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
        if (isNaN(weight) || weight == "" || new Date(date) == "Invalid Date") {
            $('#submit').prop('disabled', true);
        } else {
            $('#submit').prop('disabled', false);
        }
    }

    $('#submit').click(function(e) {
        e.preventDefault();
        let dateTime = $('#datetimepicker').val();
        console.log('date: ', dateTime);
        let weight = $('#weight').val();
        console.log('weight: ', weight);

        $.ajax({
            url: '../insertWeight.php',
            type: 'post',
            data: {dateTime: dateTime, weight: weight},
            success: function (response) {
                window.location.replace('/views/viewWeights.php');
            },
            error: function (response) {
                console.log('%cError: inserting weight', 'color:red;font-weight:bold;');
            }
        });
    });
});
$(document).ready(function() {
    $('#viewWeightsBtn').css('text-decoration', 'underline');

    $('#weightInput').on('input', function() {
        let weight = this.value;
        let date = $('#datetimepicker').val()
        verifyInput(date, weight);
    });

    $('#datetimepicker').on('input', function() {
        let date = this.value;
        let weight = $('#weightInput').val();
        verifyInput(date, weight);
    });

    $('#datetimepicker').on('change', function() {
        let date = this.value;
        let weight = $('#weightInput').val();
        verifyInput(date, weight);
    });

    function verifyInput(date, weight) {
        if (isNaN(weight) || weight == "" || new Date(date) == "Invalid Date") {
            $('#editSubmit').prop('disabled', true);
        } else {
            $('#editSubmit').prop('disabled', false);
        }
    }
});


let id, date, weight;
$('[id^=delete-button-]').click(function() {
    id = $(this).data('id');
    let date = $(this).data('date');
    let weight = $(this).data('weight');

    $('#deleteWeightModal .modal-body .date').html(date);
    $('#deleteWeightModal .modal-body .weight').html(weight);
    $('#deleteWeightModal').modal('show');
});

$('#deleteConfirm').click(function() {
    $.ajax({
        url: '../deleteWeight.php',
        type: 'post',
        data: {id: id},
        success: function (response) {
            // Remove deleted weight record table row from view.
            $('#table-row-' + id).remove();
            
            $('#deleteWeightModal').modal('hide');
            $('#weightDeletedModal').modal('show');
        },
        error: function (response) {
            $('#deleteWeightModal').modal('hide');
            $('#errorDeletingWeightModal').modal('show');
        }
    });
});

$('[id^=edit-button-]').click(function() {
    id = $(this).data('id');
    date = $(this).data('date');
    weight = $(this).data('weight');

    $('#editWeightModal .modal-body .datetime').val(date);
    $('#editWeightModal .modal-body .weight').val(weight);

    $('#editWeightModal').modal('show');
});

$('#editSubmit').click(function() {
    let updatedDateTime = $('#datetimepicker').val();
    let updatedWeight = $('#weightInput').val();

    $.ajax({
        url: '../updateWeight.php',
        type: 'post',
        data: {id: id, dateTime: updatedDateTime, weight: updatedWeight},
        success: function (response) {
            $('#editWeightModal').modal('hide');
            $('#oldDateTime').html(date);
            $('#oldWeight').html(weight);
            $('#updatedDateTime').html(updatedDateTime);
            $('#updatedWeight').html(updatedWeight);

            // Update data in the table row.
            $('#table-row-' + id + ' .td-date').html(updatedDateTime);
            $('#table-row-' + id + ' .td-weight').html(updatedWeight);

            // Update data attributes for edit and delete buttons of updated table row.
            $('#edit-button-' + id).data('date', updatedDateTime);
            $('#edit-button-' + id).data('weight', updatedWeight);
            $('#delete-button-' + id).data('date', updatedDateTime);
            $('#delete-button-' + id).data('weight', updatedWeight);

            $('#weightEditedModal').modal('show');
        },
        error: function (response) {
            $('#editWeightModal').modal('hide');
            $('#errorEditingWeightModal').modal('show');         
        }
    });
});
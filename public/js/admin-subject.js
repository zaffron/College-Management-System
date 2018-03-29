// add a new post

var subjectCount = parseInt($('#subjectCount').text());

$('.modal-footer').on('click', '.add', function() {
    $.ajax({
        type: 'POST',
        url: 'subject',
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_add').val(),
            'description': $('#description_add').val(),
        },
        success: function(data) {

            if ((data.errors)) {
                setTimeout(function () {
                    $('#addModal').modal('show');
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);

                if (data.errors.name) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.name);
                }
            } else {
                toastr.success('Successfully added Subject!', 'Success Alert', {timeOut: 5000});
                subjectCount += 1;
                $('#subjectCount').text(subjectCount);
                $('#subjectTable').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td>" + data.description + "</td><td><button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' data-description='" + data.description + "' ><span class='fa fa-edit'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='fa fa-trash'></span></button></td></tr>");
                $('#addModal').modal('hide');
                if($('#noSubject').length != 0){
                    $(document).ajaxStop(function(){
                        window.location.reload();
                    });
                }
            }
        },
    });
});


// Edit a post
$(document).on('click', '.edit-modal', function() {
    $('#name_edit').val($(this).data('name'));
    $('#description_edit').val($(this).data('description'));
    $('#id_edit').val($(this).data('id'));
    id = $(this).data('id');
    $('#editModal').modal('show');
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'PUT',
        url: 'subject/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_edit').val(),
            'description': $('#description_edit').val(),
        },
        success: function(data) {
            $('.errorTitle').addClass('hidden');
            $('.errorContent').addClass('hidden');

            if ((data.errors)) {
                setTimeout(function () {
                    $('#editModal').modal('show');
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);

                if (data.errors.name) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.name);
                }
                if (data.errors.description) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.description);
                }
            } else {
                toastr.success('Successfully updated Subject!', 'Success Alert', {timeOut: 5000});
                $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td>" + data.description + "</td><td><button class='edit-modal btn btn-info btn-sm'  data-id='" +  data.id + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-edit'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='fa fa-trash'></span></button></td></tr>");
                $('#editModal').modal('hide');

            }
        }
    });
});

// delete a post
$(document).on('click', '.delete-modal', function() {
    $('#id_delete').val($(this).data('id'));
    $('#name_delete').val($(this).data('name'));
    id = $(this).data('id');
    $('#deleteModal').modal('show');
});
$('.modal-footer').on('click', '.delete', function() {
    $.ajax({
        type: 'DELETE',
        url: 'subject/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function(data) {
            toastr.success('Successfully deleted Subject!', 'Success Alert', {timeOut: 5000});
            subjectCount -= 1;
            $('#subjectCount').text(subjectCount);
            $('.item' + data['id']).remove();
            $('#deleteModal').modal('hide');
        }
    });
});

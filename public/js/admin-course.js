// add a new post
var courseCount = parseInt($('#courseCount').text());

$('.modal-footer').on('click', '.add', function() {
    $.ajax({
        type: 'POST',
        url: 'course',
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_add').val(),
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
                toastr.success('Successfully added Course!', 'Success Alert', {timeOut: 5000});
                courseCount += 1;
                $('#courseCount').text(courseCount);
                $('#courseTable').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='fa fa-edit'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='fa fa-trash'></span></button></td></tr>");
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
    $('#id_edit').val($(this).data('id'));
    id = $(this).data('id');
    $('#editModal').modal('show');
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'PUT',
        url: 'course/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_edit').val(),
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
            } else {
                toastr.success('Successfully updated Course!', 'Success Alert', {timeOut: 5000});
                $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><button class='edit-modal btn btn-info btn-sm'  data-id='" +  data.id + "' data-name='" + data.name + "'><span class='fa fa-edit'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='fa fa-trash'></span></button></td></tr>");

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
        url: 'course/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function(data) {
            toastr.success('Successfully deleted Course!', 'Success Alert', {timeOut: 5000});
            courseCount -= 1;
            $('#courseCount').text(courseCount);
            $('.item' + data['id']).remove();
            $('#deleteModal').modal('hide');
        }
    });
});

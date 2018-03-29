// add a new post
var courseCount = parseInt($('#courseCount').text());


$('.modal-footer').on('click', '.add', function() {
    $.ajax({
        type: 'POST',
        url: 'course',
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_add').val(),
            'description' : $('#description_add').val(),
            'subjects': $('#input-subjects').val(),
            'semester': $('#semester_add').val(),
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
                if (data.errors.description) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.description);
                }
                if (data.errors.subjects) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.subjects);
                }
                if (data.errors.semester) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.semester);
                }
            } else {
                toastr.success('Successfully added Course!', 'Success Alert', {timeOut: 5000});
                courseCount += 1;
                $('#courseCount').text(courseCount);
                $('#addModal').modal('hide');
                $(document).ajaxStop(function(){
                    window.location.reload();
                });
            }
        },
    });
});


// Edit a post
$(document).on('click', '.edit-modal', function() {
    $('#name_edit').val($(this).data('name'));
    $('#username_edit').val($(this).data('username'));
    $('#email_edit').val($(this).data('email'));
    $('#department_edit').val($(this).data('department'));
    $('#gender_edit').val($(this).data('gender'));
    $('#course_edit').val($(this).data('course'));
    var subjects = ($(this).data('subjects'));
    var sub_id = subjects.split(",");
    var $select = $('#edit-subjects').selectize();
    var selectize = $select[0].selectize;
    selectize.setValue(sub_id);
    id = $(this).data('id');
    $('#editModal').modal('show');
    $('#edit-subjects').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
    });
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'PUT',
        url: 'course/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_edit').val(),
            'semester': $('#semester_edit').val(),
            'subjects': $('#edit-subjects').val(),
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
                if (data.errors.subjects) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.subjects);
                }
            } else {
                toastr.success('Successfully updated Course!', 'Success Alert', {timeOut: 5000});
                $(document).ajaxStop(function(){
                    window.location.reload();
                });
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



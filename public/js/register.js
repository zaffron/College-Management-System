/*Adding Results*/


$(document).on('click', '.add-register', function() {
    $.ajax({
        type: 'POST',
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:  'register',
        data: {
            'course': $('#course_add').val(),
            'subject': $('#subject_add').val(),
            'semester': $('#semester_add').val(),
            'section': $('#section_add').val(),
        },
        success: function(data) {
            if ((data.errors)) {
                setTimeout(function () {
                    $('#addModal').modal('show');
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);
            } else {
                toastr.success('Register created successfully!', 'Success Alert', {timeOut: 5000});
                $(document).ajaxStop(function(){
                    window.location.reload();
                });
            }
        }
    });
});


// Edit a post
$(document).on('click', '.edit-modal', function() {
    $('#name_edit').val($(this).data('name'));
    $('#regno_edit').val($(this).data('regno'));
    $('#email_edit').val($(this).data('email'));
    $('#contact_edit').val($(this).data('contact'));
    $('#dob_edit').val($(this).data('dob'));
    $('#course_edit').val($(this).data('course'));
    $('#gender_edit').val($(this).data('gender'));
    $('#proctor_edit').val($(this).data('proctor'));
    $('#address_edit').val($(this).data('address'));
    $('#semester_edit').val($(this).data('semester'));
    $('#avatar_edit').val($(this).data('avatar'));
    id = $(this).data('id');
    $('#editModal').modal('show');
});

$(document).on('click', '.edit', function(e) {
    
  e.preventDefault();

  var formData = new FormData($('#edit-student')[0]);
    formData.append("_method" , "PATCH" );

    $.ajax({
        type: 'POST',
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:  'student/' + id,
        enctype: 'multipart/form-data',
        async: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
            if ((data.errors)) {
                setTimeout(function () {
                    $('#editModal').modal('show');
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);

                if (data.errors.name) {
                    $('.errorTitle').removeClass('hidden');
                    $('.errorTitle').text(data.errors.name);
                }
                if (data.errors.course) {
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.description);
                }
            } else {
                toastr.success('Successfully updated Student!', 'Success Alert', {timeOut: 5000});
                $(document).ajaxStop(function(){
                    window.location.reload();
                });

            }
        }
    });
});

// delete a register
$(document).on('click', '.delete-register', function() {
    $('#regno_delete').val($(this).data('regno'));
    $('#name_delete').val($(this).data('name'));
    $('#course_delete').val($(this).data('course'));
    $('#deleteModal').modal('show');
    id = $(this).data('id');
});
$('.modal-footer').on('click', '.delete', function() {
    $.ajax({
        type: 'DELETE',
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'student/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function(data) {
            toastr.success('Successfully deleted Student!', 'Success Alert', {timeOut: 5000});
            studentCount -= 1;
            $('#studentCount').text(studentCount);
            $('.item' + data['id']).remove();
            $('#deleteModal').modal('hide');
        }
    });
});

// add a new post
var deptCount = parseInt($('#deptCount').text());
$(document).on('click', '.add-modal', function() {
    $('.modal-name').text('Add');
    $('#addModal').modal('show');
});
$('.modal-footer').on('click', '.add', function() {
    $.ajax({
        type: 'POST',
        url: 'department',
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_add').val(),
            'course': $('#course_add').val(),
            'description': $('#description_add').val()
        },
        success: function(data) {
            /*$('.errorTitle').addClass('hidden');
            $('.errorContent').addClass('hidden');
            */

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
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.description);
                }
            } else {
                toastr.success('Successfully added Department!', 'Success Alert', {timeOut: 5000});
                deptCount += 1;
                $('#deptCount').text(deptCount);
                    $('#deptTable').append("\
                        <tr class='item" + data.id + "'>\
                            <td>" + data.id + "</td>\
                            <td>" + data.name + "</td>\
                            <td>" + data.description + "</td>\
                            <td>" + data.courseName +"</td>\
                            <td>" + "0" + "</td>\
                            <td>" + "0" + "</td>\
                            <td><span class='text-success'>Active</span></td>\
                            <td>\
                                <button class='show-modal btn btn-success btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' data-course='" + data.course + "' data-description='" + data.description + "'><span class='fa fa-eye'></span></button>\
                                <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-name='" + data.name + "'data-course='" + data.course + "' data-description='" + data.description + "'><span class='fa fa-edit'></span></button>\
                                <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' data-course='" + data.course + "' data-description='" + data.description + "'><span class='fa fa-trash'></span></button></td>\
                        </tr>");
            }
        },
    });
});

// Show a post
$(document).on('click', '.show-modal', function() {
    $('.modal-name').text('Show');
    $('#id_show').val($(this).data('id'));
    $('#name_show').val($(this).data('name'));
    $('#course_show').val($(this).data('course'));
    $('#description_show').val($(this).data('description'));
    $('#showModal').modal('show');
});


// Edit a post
$(document).on('click', '.edit-modal', function() {
    $('.modal-name').text('Edit');
    $('#id_edit').val($(this).data('id'));
    $('#name_edit').val($(this).data('name'));
    $('#description_edit').val($(this).data('description'));
    $('#course_edit').val($(this).data('course'));
    id = $('#id_edit').val();
    $('#editModal').modal('show');
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'PUT',
        url: 'department/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $("#id_edit").val(),
            'name': $('#name_edit').val(),
            'course': $('#course_edit').val(),
            'description': $('#description_edit').val()
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
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.description);
                }
            } else {
                toastr.success('Successfully updated Department!', 'Success Alert', {timeOut: 5000});
                if(data.active){
                    $('.item' + data.id).replaceWith("\
                        <tr class='item" + data.id + "'>\
                            <td>" + data.id + "</td>\
                            <td>" + data.name + "</td>\
                            <td>" + data.description + "</td>\
                            <td>" + data.courseName + "</td>\
                            <td>" + data.teachers_count + "</td>\
                            <td>" + data.students_count + "</td>\
                            <td><span class='text-success'>Active</span></td>\
                            <td>\
                                <button class='show-modal btn btn-success btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-eye'></span></button>\
                                <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-edit'></span></button> \
                                <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-trash'></span></button></td>\
                        </tr>\
                        ");
                }else{
                    $('.item' + data.id).replaceWith("\
                        <tr class='item" + data.id + "'>\
                            <td>" + data.id + "</td>\
                            <td>" + data.name + "</td>\
                            <td>" + data.description + "</td>\
                            <td>" + data.courseName + "</td>\
                            <td>" + data.teachers_count + "</td>\
                            <td>" + data.students_count + "</td>\
                            <td><span class='text-danger'>Inactive</span></td>\
                            <td>\
                                <button class='show-modal btn btn-success btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-eye'></span></button>\
                                <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-edit'></span></button> \
                                <button class='active-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-check'></span></button></td>\
                        </tr>\
                        ");

                }
            }
        }
    });
});

// delete a post
$(document).on('click', '.delete-modal', function() {
    $('.modal-name').text('Delete');
    $('#id_delete').val($(this).data('id'));
    $('#name_delete').val($(this).data('name'));
    $('#deleteModal').modal('show');
    id = $('#id_delete').val();
});
$('.modal-footer').on('click', '.delete', function() {
    $.ajax({
        type: 'DELETE',
        url: 'department/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function(data) {
            if(data.delete){
                toastr.success('Successfully deleted Department!', 'Success Alert', {timeOut: 5000});
                deptCount -= 1;
                $('#deptCount').text(deptCount);
                $('.item' + data['id']).remove();
            }
            else{
                toastr.warning('Department deactivated successfully!', 'Deactivation Alert', {timeOut: 5000});
                $('.item' + data.id).replaceWith("\
                        <tr class='item" + data.id + "'>\
                            <td>" + data.id + "</td>\
                            <td>" + data.name + "</td>\
                            <td>" + data.description + "</td>\
                            <td>" + data.courseName + "</td>\
                            <td>" + data.teachers_count + "</td>\
                            <td>" + data.students_count + "</td>\
                            <td><span class='text-danger'>Inactive</span></td>\
                            <td>\
                                <button class='show-modal btn btn-success btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-eye'></span></button>\
                                <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-edit'></span></button> \
                                <button class='active-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-check'></span></button></td>\
                        </tr>\
                        ");
            }
        }
    });
});

//Activating the department
$(document).on('click', '.active-modal', function(){
   $('#id_activate').val($(this).data('id'));
   $('#name_activate').val($(this).data('name'));
   $('#activateModal').modal('show');
   id = $('#id_activate').val();
});

$('.modal-footer').on('click', '.activate', function(){
   $.ajax({
      type: 'POST',
       url: 'department/activate/' + id,
       data:{
          '_token': $('input[name=_token]').val(),
       },
       success:function(data){
           toastr.info('Department activated successfully!', 'Deactivation Activate', {timeOut: 5000});
           $('.item' + data.id).replaceWith("\
                        <tr class='item" + data.id + "'>\
                            <td>" + data.id + "</td>\
                            <td>" + data.name + "</td>\
                            <td>" + data.description + "</td>\
                            <td>" + data.courseName + "</td>\
                            <td>" + data.teachers_count + "</td>\
                            <td>" + data.students_count + "</td>\
                            <td><span class='text-success'>Active</span></td>\
                            <td>\
                                <button class='show-modal btn btn-success btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-eye'></span></button>\
                                <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-edit'></span></button> \
                                <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-course='" + data.course + "' data-name='" + data.name + "' data-description='" + data.description + "'><span class='fa fa-trash'></span></button></td>\
                        </tr>\
                        ");

       }

   });
});
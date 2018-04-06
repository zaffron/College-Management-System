// add a new post
var studentCount = parseInt($('#studentCount').text());

/*Updating details*/


$(document).on('click', '.add', function(e) {
  e.preventDefault();

  var formData = new FormData($('#add-student-form')[0]);

    $.ajax({
        type: 'POST',
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:  'student',
        enctype: 'multipart/form-data',
        async: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {

            if ((data.errors)) {
                setTimeout(function () {
                    $('#addModal').modal('show');
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);
            } else {
                toastr.success('Successfully added Student!', 'Success Alert', {timeOut: 5000});
                    $(document).ajaxStop(function(){
                        window.location.reload();
                    });
            }
        }
    });
});


// Show a post
$(document).on('click', '.show-modal', function() {
    $('#regno_show').val($(this).data('regno'));
    $('#email_show').val($(this).data('email'));
    $('#gender_show').val($(this).data('gender'));
    $('#course_show').val($(this).data('course'));
    $('#name_show').val($(this).data('name'));
    $('#dob_show').val($(this).data('dob'));
    $('#proctor_show').val($(this).data('proctor'));
    $('#contact_show').val($(this).data('contact'));
    $('#semester_show').val($(this).data('semester'));
    $('#avatar-show').attr('src', $(this).data('avatar'));
    $('#address_show').val($(this).data('address'));
    $('#showModal').modal('show');
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

// delete a post
$(document).on('click', '.delete-modal', function() {
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

/*
* Import and Export
* ==================
* */

//Import Excel

$(document).on('click', '#importXLS', function(){
    $('#xTitle').text("Import Excel file");
   $('.xConfirm').text("Import");
    var url = 'postImport';
    var type = 'xls';
});

//Import CSV

$(document).on('click', '#importCSV', function(){
    $('#xTitle').text("Import CSV file");
    $('.xConfirm').text("Import");
    var url = 'postImport';
    var type = 'csv';
});


//Importing file
$('.modal-footer').on('click', '.xConfirm', function() {
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            '_token': $('input[name=_token]').val(),
            'file' : $('input[name=file]').val(),
        },
        success: function(data) {
            toastr.success('Operation Successful!', 'Success Alert', {timeOut: 5000});
        }
    });
});

//Exporting data
$('#export-menu').on('click', '.export', function() {
    var type = $(this).data('type');


    $.ajax({
        type: 'POST',
        url: 'postExport/'+ type,
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function(data) {
            toastr.success('Operation Successful!', 'Success Alert', {timeOut: 5000});
        }
    });
});


// -- Bar Chart Students per department
var ctx = document.getElementById("myBarChart");

var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: deptNames,
        datasets: [{
            label: "Students Number",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: studCounts,
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                    unit: 'Department'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 20
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 100,
                    maxTicksLimit: 6
                },
                gridLines: {
                    display: true
                }
            }],
        },
        legend: {
            display: true
        }
    }
});
// add a new post
var studentCount = parseInt($('#studentCount').text());


$('.modal-footer').on('click', '.add', function() {
    $.ajax({
        type: 'POST',
        url: 'student',
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_add').val(),
            'email': $('#email_add').val(),
            'regno': $('#regno_add').val(),
            'contact':$('#contact_add').val(),
            'dob': $('#dob_add').val(),
            'course': $('#course_add').val(),
            'gender': $('#gender_add').val(),
            'proctor': $('#proctor_add').val(),
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
                if (data.errors.email) {
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.email);
                }
            } else {
                toastr.success('Successfully added Student!', 'Success Alert', {timeOut: 5000});
                studentCount += 1;
                $('#studentCount').text(studentCount);
                $('#studentTable').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.regno + "</td><td>" + data.name + "</td><td>" + data.department + "</td><td><button class='show-modal btn btn-success btn-sm' data-regno='" + data.regno + "' data-id='" + data.id + "' data-gender='" + data.gender + "' data-proctor='" + data.proctor + "' data-email='" + data.dob + "' data-email='" + data.contact + "' data-email='" + data.email + "' data-name='" + data.name + "' data-department='" + data.department + "'><span class='fa fa-eye'></span></button> <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-gender='" + data.gender + "' data-proctor='" + data.proctor + "' data-email='" + data.dob + "' data-email='" + data.contact + "' data-email='" + data.email + "' data-name='" + data.name + "' data-department='" + data.department + "' data-regno='" + data.regno +"'><span class='fa fa-edit'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-regno='" + data.regno + "' data-name='" + data.name + "' data-department='" + data.department + "'><span class='fa fa-trash'></span></button></td></tr>");
                $('#addModal').modal('hide');
                if($('#noStudent').length != 0){
                    $(document).ajaxStop(function(){
                        window.location.reload();
                    });
                }
            }
        },
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
    id = $(this).data('id');
    $('#editModal').modal('show');
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'PUT',
        url: 'student/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_edit').val(),
            'email': $('#email_edit').val(),
            'regno': $('#regno_edit').val(),
            'contact':$('#contact_edit').val(),
            'dob': $('#dob_edit').val(),
            'course': $('#course_edit').val(),
            'gender': $('#gender_edit').val(),
            'proctor': $('#proctor_edit').val(),
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
                if (data.errors.course) {
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.description);
                }
            } else {
                toastr.success('Successfully updated Student!', 'Success Alert', {timeOut: 5000});
                $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.regno + "</td><td>" + data.name + "</td><td>" + data.courseName + "</td><td><button class='show-modal btn btn-success btn-sm' data-dob='" +  data.dob + "' data-regno='" +  data.regno +  "' data-id='" +  data.id + "' data-gender='" +  data.gender +  "' data-proctor='" + data.proctor + "' data-email='" + data.email + "' data-contact='" + data.contact + "' data-name='" + data.name + "' data-course='" + data.course + "'><span class='fa fa-eye'></span></button> <button class='edit-modal btn btn-info btn-sm' data-dob='" +  data.dob + "' data-regno='" +  data.regno +  "' data-id='" +  data.id + "' data-gender='" +  data.gender +  "' data-proctor='" + data.proctor + "' data-email='" + data.email + "' data-contact='" + data.contact + "' data-name='" + data.name + "' data-course='" + data.course + "'><span class='fa fa-edit'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' data-course='" + data.course + "'><span class='fa fa-trash'></span></button></td></tr>");

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
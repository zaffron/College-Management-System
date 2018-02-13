// add a new user
var userCount = parseInt($('#userCount').text());
var adminCount = parseInt($('#adminCount').text());

$(document).on('click', '.add-modal', function() {
    title = $(this).data('admin');
    if(title == "Admin") {
        addUrl = 'create';
        $('.dept-row').hide();
    }else{
        addUrl = 'user';
    }
    $('.modal-name').text("Add " + title);
    $('#addUserModal').modal('show');
});

$('.modal-footer').on('click', '.add-user', function() {
    $.ajax({
        type: 'POST',
        url: addUrl,
        data: {
            '_token': $('input[name=_token]').val(),
            'name': $('#name_add').val(),
            'username': $('#username_add').val(),
            'email' : $('#email_add').val(),
            'password': $('#password_add').val(),
            'password_confirmation': $('#confirm_password_add').val(),
            'department': $('#department_add').val(),
            'gender': $('#gender_add').val(),
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
                if (data.errors.username) {
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.username);
                }
                if (data.errors.email) {
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.email);
                }
                if (data.errors.password) {
                    $('.errorContent').removeClass('hidden');
                    $('.errorContent').text(data.errors.password);
                }
            } else {
                if(title == "Admin"){
                    toastr.success('Successfully added Admin!', 'Success Alert', {timeOut: 5000});
                    adminCount += 1;
                    $('#adminCount').text(adminCount);
                    $('#adminsTable').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.username + "</td><td>" + data.email + "</td><td><button class='show-modal btn btn-success btn-sm' data-id='" + data.id + "' data-department='" + data.department + "' data-name='" + data.username + "' data-email='" + data.email + "'><span class='fa fa-eye'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' data-description='" + data.username + "'><span class='fa fa-trash'></span></button></td></tr>");
                }else{
                    toastr.success('Successfully added User!', 'Success Alert', {timeOut: 5000});
                    userCount += 1;
                    $('#userCount').text(userCount);
                    $('#usersTable').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.username + "</td><td>" + data.email + "</td><td><button class='show-modal btn btn-success btn-sm' data-id='" + data.id + "' data-name='" + data.username + "' data-email='" + data.email + "'><span class='fa fa-eye'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "' data-description='" + data.username + "'><span class='fa fa-trash'></span></button></td></tr>");
                }
            }
        },
    });
});

// Show a user
$(document).on('click', '.show-modal', function() {
    title = $(this).data('admin');
    $('.modal-name').text('Show');
    $('#id_show').val($(this).data('id'));
    $('#name_show').val($(this).data('name'));
    $('#username_show').val($(this).data('username'));
    $('#email_show').val($(this).data('email'));
    $('#department_show').val($(this).data('department'));
    $('#gender_show').val($(this).data('gender'));
    $('#showModal').modal('show');
    if(title == "admin"){
        $('.dept-row').hide();
    }
});


// delete a post
$(document).on('click', '.delete-modal', function() {
    $('.modal-name').text('Delete');
    $('#id_delete').val($(this).data('id'));
    $('#name_delete').val($(this).data('name'));
    $('#deleteModal').modal('show');
    id = $('#id_delete').val();
    admin = $(this).data('admin');
    if(admin == "admin") {
        url = "destroy/";
    }else{
        url = "user/";
    }
});
$('.modal-footer').on('click', '.delete', function() {
    $.ajax({
        type: 'DELETE',
        url: url + id,
        data: {
            '_token': $('input[name=_token]').val(),
        },
        success: function(data) {
            if(data.message){
                toastr.error('Deletion Error!', 'Sorry an admin cannot kill himself', {timeOut: 5000});
            }else{
                if(admin == "admin"){
                    toastr.success('Successfully deleted the admin!', 'Success Alert', {timeOut: 5000});
                    adminCount -= 1;
                    $('#adminCount').text(adminCount);
                    $('.adminItem' + data['id']).remove();
                }else{
                    toastr.success('Successfully deleted the user!', 'Success Alert', {timeOut: 5000});
                    userCount -= 1;
                    $('#userCount').text(userCount);
                    $('.userItem' + data['id']).remove();
                }
            }
        }
    });
});

// -- Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
// -- Pie Chart User
var ctx = document.getElementById("myPieChart");
var colors = ['#007bff', '#dc3545', '#ffc107', '#28a745', '#FEFEFE', '#474758'];
var useColors = new Array();

for(i=0;i<departmentNames.length;i++)
{
    useColors.push(colors[i]);
}

var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: departmentNames,
        datasets: [{
            data: dataValues,
            backgroundColor: useColors,
        }],
    },
});
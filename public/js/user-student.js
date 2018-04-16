
// Show a student
$('.show-modal').click(function() {
    $('#regno_show').val($(this).data('regno'));
    $('#email_show').val($(this).data('email'));
    $('#gender_show').val($(this).data('gender'));
    $('#course_show').val($(this).data('course'));
    $('#name_show').val($(this).data('name'));
    $('#dob_show').val($(this).data('dob'));
    $('#proctor_show').val($(this).data('proctor'));
    $('#address_show').val($(this).data('address'));
    $('#contact_show').val($(this).data('contact'));
    $('#parent_email_show').val($(this).data('p_email'));
    $('#parent_contact_show').val($(this).data('p_contact'));
    $('#showModal').modal('show');
});

// edit a proctee
$(document).on('click', '.update-proctee', function() {
	$.ajax({
		type: 'POST',
		url: '/proctee/update',
		headers: {
		      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			'regno': $('#regno_show').val(),
			'email': $('#email_show').val(),
			'contact': $('#contact_show').val(),
			'parent_email': $('#parent_email_show').val(),
			'parent_contact': $('#parent_contact_show').val(),
			'address': $('#address_show').val(),
		},
		success: function(data) {
		    if ((data.errors)) {
		            $('#showModal').modal('show');
		            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
		            if(data.errors.email){
		            	toastr.error('Invalid email!', 'Error Alert', {timeOut: 5000});
		            }if(data.errors.contact){
		            	toastr.error('Invalid proctee contact!', 'Error Alert', {timeOut: 5000});
		            }if(data.errors.address){
		            	toastr.error('Invalid address!', 'Error Alert', {timeOut: 5000});
		            }if(data.errors.p_contact){
		            	toastr.error('Invalid parent contact!', 'Error Alert', {timeOut: 5000});
		            }
		    } else {
		        toastr.success('Successfully updated proctee!', 'Success Alert', {timeOut: 5000});
		            $(document).ajaxStop(function(){
		                window.location.reload();
		            });
		    }
		}
	});
});


// On click of announcement button
$(document).on('click', '.announce', function(){
	$.ajax({
	    type: 'POST',
	    url: 'announcement/create',
	    headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	    data: {
	        'id': $('#user_id').val(),
	        'message': $('#message').val(),
	    },
	    success: function(data) {
	        if ((data.errors)) {
	            setTimeout(function () {
	                toastr.error('No Message found!', 'Error Alert', {timeOut: 5000});
	            }, 500);
	        } else {
	            toastr.info('Announcement Done!', 'Success Alert', {timeOut: 5000});
	        }
	    },
	});
});

// On click of end semester button
$(document).on('click', '.announce_semester_end', function(){
	$.ajax({
	    type: 'POST',
	    url: 'announcement/semester',
	    headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	    data: {
	        'course': $('#sem_end_course').val(),
	    },
	    success: function(data) {
	        if ((data.errors)) {
	            setTimeout(function () {
	                toastr.error('No Message found!', 'Error Alert', {timeOut: 5000});
	            }, 500);
	        } else {
	            toastr.info('Semester end announced!', 'Success Alert', {timeOut: 5000});
	        }
	    },
	});
});
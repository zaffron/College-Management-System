// Notification shower
function notificationExpander(sender, message){
      $("#sender").text(sender);
      $("#message").text(message);
}
// For making notification as read
$(function(){
	$('#user-nav>.message-container').click(function(){
		$.get('/markAsReadUser/' + $(this).data('id'));
	});
	$('#admin-nav>.message-container').click(function(){
		$.get('admin/markAsReadAdmin/' + $(this).data('id'));
	});
});

function changeThemeUser(id)
{
	var was_status = $('#theme-changer').hasClass('active');
	// if false then dark mode should be on
	if(was_status){
		// Here light mode code
		$('nav').addClass('navbar-light');
		$('nav').removeClass('navbar-dark');
		$('nav').addClass('bg-light');
		$('nav').removeClass('bg-dark');
		$('body').addClass('bg-light');
		$('body').removeClass('bg-dark');
		$.ajax({
		    type: 'POST',
		    headers: {
		          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    url:  '/changeUserTheme/' + 0,
		    data: {
		    },
		    success: function(data) {
		        if ((data.errors)) {
		            setTimeout(function () {
		                toastr.error('Cannot change theme!', 'Error Alert', {timeOut: 5000});
		            }, 500);
		        } else {
		            toastr.info('Mode switched!', 'Success Alert', {timeOut: 5000});
		        }
		    }
		});
	}else{
		// Here dark mode code
		$('nav').addClass('navbar-dark');
		$('nav').removeClass('navbar-light');
		$('nav').addClass('bg-dark');
		$('nav').removeClass('bg-light');
		$('body').addClass('bg-dark');
		$('body').removeClass('bg-light');
		$.ajax({
		    type: 'POST',
		    headers: {
		          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    url:  '/changeUserTheme/' + 1,
		    data: {
		    },
		    success: function(data) {
		        if ((data.errors)) {
		            setTimeout(function () {
		                toastr.error('Cannot change theme!', 'Error Alert', {timeOut: 5000});
		            }, 500);
		        } else {
		            toastr.info('Mode switched!', 'Success Alert', {timeOut: 5000});
		        }
		    }
		});
	}
}

function changeThemeAdmin(id)
{
	var was_status = $('#theme-changer').hasClass('active');
	// if false then dark mode should be on
	if(was_status){
		// Here light mode code
		$('nav').addClass('navbar-light');
		$('nav').removeClass('navbar-dark');
		$('nav').addClass('bg-light');
		$('nav').removeClass('bg-dark');
		$('body').addClass('bg-light');
		$('body').removeClass('bg-dark');
		$.ajax({
		    type: 'POST',
		    headers: {
		          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    url:  'admin/changeAdminTheme/' + 0,
		    data: {
		    },
		    success: function(data) {
		        if ((data.errors)) {
		            setTimeout(function () {
		                toastr.error('Cannot change theme!', 'Error Alert', {timeOut: 5000});
		            }, 500);
		        } else {
		            toastr.info('Mode switched!', 'Success Alert', {timeOut: 5000});
		        }
		    }
		});
	}else{
		// Here dark mode code
		$('nav').addClass('navbar-dark');
		$('nav').removeClass('navbar-light');
		$('nav').addClass('bg-dark');
		$('nav').removeClass('bg-light');
		$('body').addClass('bg-dark');
		$('body').removeClass('bg-light');
		$.ajax({
		    type: 'POST',
		    headers: {
		          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    url:  'admin/changeAdminTheme/' + 1,
		    data: {
		    },
		    success: function(data) {
		        if ((data.errors)) {
		            setTimeout(function () {
		                toastr.error('Cannot change theme!', 'Error Alert', {timeOut: 5000});
		            }, 500);
		        } else {
		            toastr.info('Mode switched!', 'Success Alert', {timeOut: 5000});
		        }
		    }
		});
	}
}
// This js file is only for taking attendance part where we will take the live attendance of the student

$("form").submit(function(e){
    e.preventDefault();

    var formData = new FormData(this);
    console.log('hell');
    $.ajax({
        type: 'POST',
        url:  'register/storeEach',
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
            if ((data.errors)) {
                setTimeout(function () {
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);
            } else {
                toastr.success(data.message, 'Success Alert', {timeOut: 5000});
                $('#row-'+ data.regno).animate({
                    opacity: 'hide', // animate slideUp
                    right: '200px',  // slide left
                    }, 'slow', 'linear', function() {
                      $(this).remove();
                });
            }
        },
    });
});
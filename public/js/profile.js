
// Image uploading
//=====================
$('#uploader').on('click',function(){
    $('#avatar-uploader').trigger('click');
});

function readURL(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();

           reader.onload = function (e) {
               $('#avatar-pic')
                   .attr('src', e.target.result);
           };

           reader.readAsDataURL(input.files[0]);
       }
   }

/*Updating details*/


$(document).on('click', '.update', function(e) {
	var uid = $('#uid').text();
  e.preventDefault();

  var formData = new FormData($('#profile-form')[0]);

    $.ajax({
        type: 'POST',
        url:  uid,
        enctype: 'multipart/form-data',
        async: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {

            if ((data.errors)) {
                setTimeout(function () {
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
                toastr.success('Successfully updated profile!', 'Success Alert', {timeOut: 5000});
                $('#description-container').text(data.description);
            }
        },
    });
});







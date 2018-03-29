
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

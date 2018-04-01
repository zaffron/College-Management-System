// Notification shower
function notificationExpander(sender, message){
      $("#sender").text(sender);
      $("#message").text(message);
}
// For making notification as read
$(function(){
	$('.message-container').click(function(){
		$.get('/markAsRead');
	});
});
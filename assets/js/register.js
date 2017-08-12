// Targets the document, but only when it is 'ready.'
// jQuery can only be used when page is loaded.
$(document).ready(function() {
	// When user clicks register, hide log in form and show registration form.
	$("#register_link").click(function() {
		$("#login_form").slideUp("slow", function()
		{
			$("#register_form").slideDown("slow");
		});
	});

	// When user clicks login, hide registration form and show logi n form.
	$("#login_link").click(function() {
		$("#register_form").slideUp("slow", function()
		{
			$("#login_form").slideDown("slow");
		});
	});
});
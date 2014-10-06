$("#edit-first-name").on("click", function () {
	$("#first-name").attr("disabled", false)
});

$("#edit-last-name").on("click", function () {
	$("#last-name").attr("disabled", false)
});

$("#edit-email").on("click", function () {
	$("#email").attr("disabled", false)
});

$("#edit-password").on("click", function () {
	$("#password").attr("disabled", false)
	$("#confirm-password").attr("disabled", false)
});

$("#save").on("click", function () {
	location.reload();
});

/*$("#confirm-password").on("change focus keyup", function() {
	if ( ! ($("#password").attr("value") === $("#confirm-password").attr("value")) )
		alert("Password Not Matching");
});*/
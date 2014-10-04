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
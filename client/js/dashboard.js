// enable the text field first name on click of edit
$("#edit-first-name").on("click", function () {
	$("#first-name").attr("disabled", false)
});

// enable the text field last name on click of edit
$("#edit-last-name").on("click", function () {
	$("#last-name").attr("disabled", false)
});

// enable the text field email on click of edit
$("#edit-email").on("click", function () {
	$("#email").attr("disabled", false)
});

// enable the text field password and confirm password on click of edit
$("#edit-password").on("click", function () {
	$("#password").attr("disabled", false)
	$("#confirm-password").attr("disabled", false)
});


function gofullscreen(id) {
    	var element=document.getElementById(id);
    	if (element.mozRequestFullScreen) {
      		element.mozRequestFullScreen();
    	} 
	    else if (element.webkitRequestFullScreen) {
      		element.webkitRequestFullScreen();
    	}  
    	element.play();
}

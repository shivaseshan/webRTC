function failureEvents(t,item) {
	$(t).parent().addClass("has-error");
	$(t).parent().removeClass("has-success");
	$(t).parent().find(item).addClass("glyphicon-remove");  
	$(t).parent().find(item).removeClass("glyphicon-ok");
}

function successEvents(t,item) {
	//console.log(t);
	$(t).parent().removeClass("has-error");
	$(t).parent().addClass("has-success");
	$(t).parent().find(item).removeClass("glyphicon-remove");  
	$(t).parent().find(item).addClass("glyphicon-ok");
}

$( document ).ready(function() {
	
document.getElementById("signupForm").reset();
	$("#email").on('change focus keyup',function () {
		var val = $(this).val();
		var item1 ="#emailglyph" ;
		var email = new RegExp(/^[a-zA-Z0-9]+[a-zA-Z0-9_]*\@[a-zA-Z]+\.[a-zA-Z]{2,3}/g);

		$(this).parent().addClass("has-feedback");
		$(this).parent().find(item1).addClass("glyphicon"); 
		$(this).parent().find(item1).addClass("form-control-feedback");
		if (!email.test(val) ) {
			failureEvents(this,item1);
		}
		else {
			successEvents(this,item1);
		}
	})
	$("#fname").on('change focus keyup',function() {
		var val=$(this).val();
		var item1 ="#fnameglyph" ;
		var fname= new RegExp(/^[a-zA-Z'-]+$/);
		$(this).parent().find(item1).addClass("glyphicon");  
		$(this).parent().find(item1).addClass("form-control-feedback");
		if (!fname.test(val)) {

			failureEvents(this,item1);
		}
		else {
			successEvents(this,item1);
		}

	})
	$("#lname").on('change focus keyup',function() {
		var val=$(this).val();
		var item1 ="#lnameglyph" ;
		var lname= new RegExp(/^[a-zA-Z]+$/);
		$(this).parent().find(item1).addClass("glyphicon");  
		$(this).parent().find(item1).addClass("form-control-feedback");
		if (!lname.test(val) || val=="") {
			failureEvents(this,item1);
		}
		else {
			successEvents(this,item1);

		}

	})


	$("#usrpwd").on('change focus keyup',function() {
		var val=$(this).val();
		var item1 ="#pwdglyph" ;
		//var item2= document.getElementById('cnfrmpwd').value;
		$(this).parent().find(item1).addClass("glyphicon");  
		$(this).parent().find(item1).addClass("form-control-feedback");
		if (val=="" ) {//|| item2!=val

			failureEvents(this,item1);
		}
		else {
			successEvents(this,item1);
		}
	})

	$("#cnfrmpwd").on('change focus keyup',function() {
		var val=$(this).val();
		var item1 ="#cnfrmpwdglyph" ;
		var item2= document.getElementById('usrpwd').value;
		$(this).parent().find(item1).addClass("glyphicon");  
		$(this).parent().find(item1).addClass("form-control-feedback");
		if (val=="" || item2!=val) {

			failureEvents(this,item1);
		}
		else {
			successEvents(this,item1);
		}
	})

	$("#age").on('change focus keyup',function() {
		var val=$(this).val();
		var item1 ="#ageglyph" ;
		$(this).parent().find(item1).addClass("glyphicon");  
		$(this).parent().find(item1).addClass("form-control-feedback");
		if(!val || val>100 || val<18)
		{
			failureEvents(this,item1);
		}
		else {
			successEvents(this,item1);

		}

	})

	$("#uname").on('change focus keyup',function() {
		var val=$(this).val();
		var item1 ="#unameglyph" ;
		var uname= new RegExp(/^[a-zA-Z0-9]+$/);
		$(this).parent().find(item1).addClass("glyphicon");  
		$(this).parent().find(item1).addClass("form-control-feedback");
		if (!uname.test(val) || val=="") {

			failureEvents(this,item1);
		}
		else {
			successEvents(this,item1);
		}
	})
	
	/*if($("#signupForm").find(".has-error").length>0) 
		$('#signup').attr('disabled', 'disabled');
	else
		$('#signup').removeAttr('disabled');*/
});
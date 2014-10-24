// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
  console.log('statusChangeCallback');
  console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      //document.getElementById('status').innerHTML = 'Please log ' +
      //  'into this app.';
      /*FB.login(function(response) {
        // handle the response
        console.log('res',response);
        }, {scope: 'email'});*/
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      //document.getElementById('status').innerHTML = 'Please log ' +
      //  'into Facebook.';
      /*FB.login(function(response) {
        console.log('res',response);
        // handle the response
        }, {scope: 'email'});*/
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.


  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }


  window.fbAsyncInit = function() {
    FB.init({
    appId      : '766445996750696',
    status : true,
     cookie     :true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });
// Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.
 FB.getLoginStatus(function(response) {

    statusChangeCallback(response);
  });
};

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    //console.log('Welcome!  Fetching your information.... ');
    //LodingAnimate(); //Animate login
    FB.api('/me', function(response) {
//window.location.reload();
      //console.log('Successful login for: ' + response.name);
      if (response.email == null) {
        //Facbeook user email is empty, you can check something like this.
        alert("You must allow us to access your email id!"); 
        //ResetAnimate();

      }else{
        $.ajax({
          // the URL for the request
          url: "process.php",

          // the data to send (will be converted to a query string)
          data: {
            email: response.email,
            first_name: response.first_name,
            last_name: response.last_name,
            fbid: response.id
          },

          // whether this is a POST or GET request
          type: "POST",

          // the type of data we expect back
          // dataType : "json",

          // code to run if the request succeeds;
          // the response is passed to the function
          success: function( json ) {
              window.location.replace("dashboard.php");
              //alert("success",json);
            }, 

          // code to run if the request fails; the raw request and
          // status codes are passed to the function
          error: function( xhr, status, errorThrown ) {
            alert( "Sorry, there was a problem!" );
            // console.log( "Error: " + errorThrown );
            // console.log( "Status: " + status );
            // console.dir( xhr );
          }
        });
      }
    });
  }

  $("#logout").on("click", function () {
    function logout() {
      FB.logout(function(response) {
        alert("Facebook logout");
            // Person is now logged out
        });
      }
  });
   
  //Show loading Image
  function LodingAnimate() 
  {
      $("#LoginButton").hide(); //hide login button once user authorize the application
      $("#results").html('<img src="img/ajax-loader.gif" /> Please Wait Connecting...'); //show loading image while we process user
    }

  //Reset User button
  function ResetAnimate() 
  {
      $("#LoginButton").show(); //Show login button 
      $("#results").html(''); //reset element html
  }

  $('#logout').on('click', function() {
if(response.status=== 'connected')
        FB.logout(function(response){}); 
    });

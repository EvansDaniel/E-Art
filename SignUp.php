<!
DOCTYPE HTML>
<html lang="en-US">
  
<head>
  <title>Life in Haiti</title>


  <link rel="stylesheet" type="text/css" href="styles/SignUp.css">
   <meta charset="UTF-8">
</head>

<body class="body" id="body">

<ul>
  <li id="icon"><a href="pHome.php" id="haiti"><img src="images/logo.png"></a></li> 
 </ul>



<?php

  require_once('classes/Registration.php'); 
  
  // May be able to delete because javascript checks to make sure 
  // have something in them    
  $register = new Registration();
  
  if (isset($register)) {
    if ($register->errors) {
        foreach ($register->errors as $error) {
            echo $error;
            $error = '';
        }
    }
    if ($register->messages) {
        foreach ($register->messages as $message) {
            echo $message;
        }
    }
  } 
  
?>



<!-- This check is for if the user has already submitted data-->
<?php if(!$register->registration_successful && !$register->verification_successful) { ?>

<h2 id="title">Sign Up</h2>
<form action="SignUp.php" id="SignUp" method="post" onsubmit="return ValidateForm(this);" autocomplete="on">

  <!-- not really sure what this input is used for --> 
  <input id="SnapHostID" name="SnapHostID" type="hidden" value="2835QKLFLYQQ" />

<table border="0" cellpadding="5" cellspacing="0" width="600">

  <tr>
    <td><b>Username*:</b></td>
    <td>
      <input id="Username" name="UserName" type="text" autocomplete="on"
      maxlength="60" style="width:300px; border:1px solid #999999" />
    </td>
  </tr>
  
  <tr>
    <td><b>First*</b></td>
    <td>
      <input id="FirstName" name="FirstName" type="text" autocomplete="on"
      maxlength="60" style="width:300px; border:1px solid #999999" />
  </tr>
  
  <tr>
    <td><b>Email Address*:</b></td>
    <td>
      <input id="EmailAddress" name="EmailAddress" type="text" maxlength="60" 
      autocomplete="on" style="width:300px; border:1px solid #999999" />
    </td>
  </tr>

  <tr>
    <td><b>Password*:</b></td>
    <td>
      <input id="Password" name="Password" type="password" maxlength="60" autocomplete="on"
      style="width:300px; border:1px solid #999999" />
    </td>
  </tr>

  <tr>
    <td><b>Confirm Password*:</b></td>
    <td>
      <input id="Confirm-Password" name="ConfirmPassword" type="password" maxlength="60" 
      autocomplete="on" style="width:300px; border:1px solid #999999" />
    </td>
  </tr>

  <tr>
    <td><b>Are you a college artist?</b></td>
    <td>
      <input type="checkbox" id="isArtist" name="isArtist" value="1"><br>
  </tr>

  <tr>
    <td id="text" style="display: none;"><b>College</b></td>
    <td>
      <input id="College" name="College" type="text" autocomplete="on" 
      maxlength="60" style="display: none; width:300px; border:1px solid #999999" />
  </tr>
    <td colspan="2" align="center">
    <br>
  
    <table border="0" cellpadding="0" cellspacing="0">
      <tr valign="top">
    </tr>
    </table>
    <br>
    <p>- Fields with an asterik (*) are required </p>
    <button id="submit" name="submit" type="submit" value="Submit">Submit</button>
    </td>
  </tr>
</table>
<br>
</form>
<!-- this portion runs after a successful sign up 

but before he/she has verified by email-->
<?php } else if (!($register->verification_successful)) {
  
  // setInterval(function(){ countdown(); },1000);
  echo "<p id='verify'>
        You will be redirected to the home page in 
        <span id='counter'>10</span> second(s).
        </p> <script type='text/javascript'>
              setInterval(function(){ countdown(); },1000);
             </script>
        <p>If you are not redirected, click <a href='pHome.php'>here</a></p>"; 
} ?> 

<script src="scripts/jquery-1.12.3.min.js"></script>

<script>

$('#isArtist').click(function() {
    console.log($("#text").toggle(this.checked));
    $("#College").toggle(this.checked);
});

function countdown() {

  var i = document.getElementById('counter');
    if (parseInt(i.innerHTML)<=1) {
        location.href = 'pHome.php';
    }
  i.innerHTML = parseInt(i.innerHTML)-1; 
}

</script>


<!-------------------------------------------- scripts ----------------------------------->

  <script type="text/javascript">
  function ValidateForm(form) {
    if (form.FirstName.value == "") {
      alert('First Name is required.');
      form.FirstName.focus();
      return false;
    }
    if (form.LastName.value == "") {
      alert('Last Name is required.');
      form.LastName.focus();
      return false;
    }
    if (form.Career.value == "") {
      alert('Profession/Career is required.');
      form.Career.focus();
      return false;
    }
    if (form.EmailAddress.value == "") {
      alert('Email address is required.');
      form.EmailAddress.focus();
      return false;
    }
    if (form.EmailAddress.value.indexOf("@") < 1 || 
        form.EmailAddress.value.indexOf(".") < 1) {
      alert('Please enter a valid email address.');
      form.EmailAddress.focus();
      return false;
    }
    if (form.Password.value == "") {
      alert('Password is required.');
      form.Password.focus();
      return false;
    }
    if (form.ConfirmPassword.value == "" ) {
      alert('Confirm Password is required.');
      form.ConfirmPassword.focus();
      return false;
    }
    if (form.ConfirmPassword.value != form.Password.value) {
      alert('The password and confirm password fields do not match');
      form.Password.focus();
      return false;
    }
  } 
  function ReloadCaptchaImage(captchaImageId) {
    var obj = document.getElementById(captchaImageId);
    var src = obj.src;
    var date = new Date();
    var pos = src.indexOf('&rad=');

    if (pos >= 0) { 
      src = src.substr(0, pos); 
    }
    obj.src = src + '&rad=' + date.getTime();
    
    return false; 
  } 
  </script>

</body>
 
</html>

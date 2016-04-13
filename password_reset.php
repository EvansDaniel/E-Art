<html>

<head>
</head>

<body>

<?php
  
  require_once('classes/swiftmailer/lib/swift_required.php');
  
  require_once('classes/LoginA.php');
  

  $login = new LoginA();
  
  if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
            $error = '';
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
  } 
  
  if($login->passwordResetWasSuccessful())
  {
    include("pHome.php");
  }
  else {
    include("view/password_reset.php");
  }
?>

</body>

</html>


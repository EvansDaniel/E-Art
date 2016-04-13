<h1>Reset your password</h1>

<?php
 
?>
<?php if($login->passwordResetLinkIsValid() == true || 
        
         $login->passReset() == false) { ?>
<form method="post" action="password_reset.php" name="new_password_form">
  

  <input type='hidden' name='user_email' 
  value="<?php echo htmlspecialchars($_GET['user_email']); ?>" />
  
  <input type='hidden' name='user_password_reset_hash' 
  value="<?php echo htmlspecialchars($_GET['verification_code']); ?>" />
  
  <input id="user_password_new" type="text" name="user_password_new" />
  <label for="user_password_new">new password</label><br>
  

  <input id="user_password_repeat" type="text" name="user_password_repeat"/>
  <label for="user_password_repeat">repeat new password</label>
  <input type="submit" name="submit_new_password" value="submit" /><br>

  
</form>

<?php } else { ?>

<form method="post" action="password_reset.php" name="password_reset_form">
    <label for="user_email"></label>
    <input id="user_email" type="text" name="user_email" required />
    <input type="submit" name="request_password_reset" value="send" />
</form>

<?php } ?>

<a href="i.php">Back to the home page</a>

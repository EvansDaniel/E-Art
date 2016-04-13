
<html>
<head>
</head>
<body>
<form method="post" action="edit.php" name="user_edit_form_password">
    <label for="user_password_old">Old password</label>
    <input id="user_password_old" type="text" name="user_password_old" autocomplete="off" />

    <label for="user_password_new">New password</label>
    <input id="user_password_new" type="text" name="user_password_new" autocomplete="off" />

    <label for="user_password_repeat">Confirm password</label>
    <input id="user_password_repeat" type="text" name="user_password_repeat" autocomplete="off" />

    <input type="submit" name="user_edit_submit_password" value="<?php echo WORDING_CHANGE_PASSWORD; ?>" />
</form><hr/>

</body>
</html>

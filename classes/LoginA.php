

<!--  On post login session variables available

      $_SESSION['firstName'] = $profile_object->firstName;
      $_SESSION['lastName'] = $profile_object->lastName;
      $_SESSION['user_id'] = $result_row->userId;
      $_SESSION['user_email'] = $result_row->email;
      $_SESSION['user_logged_in'] = 1;       
-->


<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

// TODO: perform html sanitation on POST vars and/or use prepared statements
// TODO: 

require_once('swiftmailer/lib/swift_required.php');
  
class LoginA

  // this script must be included before any output <html> tags 
  // and whitespace and such or else the setcookie function won't work
  
{

  private $conn = null;

  private $userId = null;

  private $user_email = "";
  
  private $resetPass = true;

  private $user_is_logged_in = false;

  private $password_reset_link_is_valid  = false;

  private $password_reset_was_successful = false;

  public $errors = array();

  public $messages = array();
  /**
   * the function "__construct()" automatically starts whenever an object of this class is created,
   * you know, when you do "$login = new LoginA();"
  */
  
  public function __construct() 
  {
    session_start();

    
    // if user tried to log out
    if (isset($_GET["logout"])) 
    {
      
      $this->doLogout();
    } 
    
    
    
    
    
    
    // if user has an active session on the server
    elseif (!empty($_SESSION['user_email']) && ($_SESSION['user_logged_in'] == 1)) 
    { 
    
      $this->loginWithSessionData();
    }
    
    
    
    
    // user try to change his email
    elseif (isset($_POST["submit_new_password"])) 
    {
      
      // function below uses $_SESSION['user_email'] and $_SESSION['user_id']
      $this->ResetUserPassword($_POST['user_password_new']
                             ,$_POST['user_password_repeat']);
                             
    }
    
    
    
    
    
    // login with cookie
    elseif (isset($_COOKIE['rememberme'])) 
    {
      
      $this->loginWithCookieData();
      
    } // end isset($_COOKIE['rememberme'])
    
    // if user just submitted a login form
    
    
    
    
    
    
    elseif (isset($_POST["login"])) 
    {
      
      if (!isset($_POST['user_rememberme'])) 
      {
        
        $_POST['user_rememberme'] = null;
      
      } // end !isset($_POST['user_rememberme']
      
      $this->loginWithPostData($_POST['user_email']
                              ,$_POST['user_password']
                              ,$_POST['user_rememberme']);
    
    } // end of isset($_POST[login])
    
     
     
     
     
     
     
     // checking if user requested a password reset mail
     if (isset($_POST["request_password_reset"]) && isset($_POST['user_email'])) 
     {
        
       $this->setPasswordResetDatabaseTokenAndSendMail($_POST['user_email']);
     } 
     
     
     
     
     elseif (isset($_GET["user_email"]) && isset($_GET["verification_code"])) 
     {

       $this->checkIfEmailVerificationCodeIsValid($_GET["user_email"]
                                                 ,$_GET["verification_code"]);
     } 
     

     
     elseif (isset($_POST["user_edit_submit_password"])) {
     
       $this->editNewPassword($_POST['user_email']
                             ,$_POST['user_password_reset_hash']
                             ,$_POST['user_password_new']
                             ,$_POST['user_password_repeat']);
     }
     

    
  }
  
  public function getConn() {
    return $this->conn;
  }
  
  
  
  
  
  
  
  
  
  
  
  
  private function databaseConnection()
  {
    // if connection already exists
    if ($this->conn != null) {

      return true;
    } 
    else {
           
      $this->conn = new mysqli('crisler.sewanee.edu'
                              ,'user'
                              ,'csci'
                              ,'artists');  
      // throw error if conn fails
      if ($this->conn->connect_error) die($this->conn->connect_error); 
      return true;
    }
    return false; 
  } // end dbConnection 
  
  
  // TODO: make all queries prepare statements 
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  private function loginWithSessionData() 
  {
    
    

    $this->user_email = $_SESSION['user_email'];
    // set logged in status to true, because we just checked for this:
    // !empty($_SESSION['user_email']) && ($_SESSION['user_logged_in'] == 1)
    // when we called this method (in the constructor)
    $this->user_is_logged_in = true;
    
  } // end loginWithSessionData() 
  
  
  
  
  
  
  
  
  
  
  
  
  private function loginWithCookieData() 
  
  {
  
    if (isset($_COOKIE['rememberme'])) 
    
    {
      // extract data from the cookie
      list ($userId, $token, $hash) = explode(':', $_COOKIE['rememberme']);
      
      // check cookie hash validity
      if ($hash == hash('sha256', $userId . ':' . $token . COOKIE_SECRET_KEY)
          && !empty($token)) 
      {
        // cookie looks good, try to select corresponding user
        if ($this->databaseConnection()) {
          
          // get real token from database (and all other data) 
        }
      }
    }
  }  // end loginWithCookieData() 
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  private function loginWithPostData($user_email,$user_password, $user_rememberme) 
  
  
  {

    echo "edsfdsf";
    // checks on the user's input 
    if(empty($user_email))  {
      $this->errors[] = "The email field is empty";
    }
    elseif (empty($user_password)) {
      $this->errors[] = "The password field is empty";
    }
    elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
      $this->errors[] = "The email address entered is invalid";      
    }
    else {
    
      echo "dsfdsf";
      // if all checks are good and db connection is good 
      // fetch all the info on the user and save it as an object
      if ($this->databaseConnection()) {
      
        // might need to fetch result row as an object 
        // ($result_row = $query_user->fetch-object();)
        $get_user_info = $this->conn->query( 
      
        "select * from artistLogin where email = '$user_email'");
        
        $result_row = $get_user_info->fetch_object();
      }
      // there is no dbconnection 
      else {
        $this->errors[] = "Error connecting to the database/no connection to database";
      }
    } // end else 
      
    // if the user doesn't exist
    // remove the user doesn't exist bit when done 
    // and replace with failed login
    if(!(isset($result_row->artistId))) {
      $this->errors[] = "This user does not exist";
    }
    /*elseif (($result_row->user_failed_logins >= 5) && 
            ($result_row->user_last_failed_login > (time() - 30))) 
    {
      $this->errors[] = "The password was wrong 5 times in a row";
    }  */
    // if the password entered's hash is not the same as the hashed password in db
    elseif (!password_verify($user_password, $result_row->passHash)) {
      // TODO: update the databases's password wrong counter 
      
      $this->errors[] = "The email/password is wrong";
    }
    else { 
    
      $userId = $result_row->artistId;
      
      // get user profile data 
      $artist_profile = $this->conn->query
      
      ("select * from artistLogin where artistId = $userId");
      
      $profile_object = $artist_profile->fetch_object();
      
      
      // write the user's data into a PHP session 
      $_SESSION['fName'] = $profile_object->fName;
      $_SESSION['lName'] = $profile_object->lName;
      $_SESSION['user_id'] = $result_row->artistId;
      $_SESSION['user_email'] = $result_row->email;
      $_SESSION['user_logged_in'] = 1;
      
      $artist_login = $this->conn->query
      
      ("select * from artistLogin where artistId = $userId");
      
      $login_object = $artist_login->fetch_object();
      
      $_SESSION['userName'] = $login_object->userName;
      $username = $_SESSION['userName'];
      
      // store path to the artist's directory to do reads and writes
      // there later if needed
      $_SESSION['path_to_artist_dir'] = "/home/evansdb0/html/" . $_SESSION['userName'];


      
      $this->userId = $result_row->artistId;
      $this->user_email = $result_row->email;
      $this->user_is_logged_in = true;

      
      // TODO: reset the failed login counter in the database
      
      // if user has check the "remember me" checkbox, 
      // then generate token to store in db and write to cookie
      if (isset($user_rememberme)) {
        // create a new remember me cooie
        $this->newRememberMeCookie();
      }
      else {
        // delete the cookie
        $this->deleteRememberMeCookie();
      } 
    } // end else for writing session data  
  } // end login With Post Data()  

  
  
  
  

  
  
  
  
  // Create all data needed for remember me cookie 
  // connection on client and server side
  private function newRememberMeCookie() 
  
  {
    
    $userId = $this->userId;
    if ($this->databaseConnection()) {
      // generate 64 char random string and store it in current user data
      $rand_token = hash('sha256', mt_rand());
      $setRememberMeToken = $this->conn->query
      
      ("UPDATE artistLogin SET rememberMe = '$rand_token' WHERE userId = $userId");
      
      $cookie_first_part = $_SESSION['user_id'] . ':' . $rand_token;
      $secret_key = '1gp@TMPS{+$78sfpMJFe-92s';
      $cookie_hash = hash('sha256', $cookie_first_part . $secret_key);
      
      $cookie_string = $cookie_first_part . ':' .  $cookie_hash;
      
      // set cookie for two weeks (1209600 seconds)
      setcookie('rememberme', $cookie_string, time() + 1209600, "/", ".sewanee.edu");
      
    } // end databaseConnection() 
  }  // newRememberMeCookie
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  // used when logging in with post data
  // will delete cookie if the remember me check box is not set
  private function deleteRememberMeCookie() 
  
  {
     $userId = $this->userId;
     if ($this->databaseConnection()) {
       $unsetRememberMeToken = $this->conn->query
      
       ("UPDATE artistLogin SET rememberMe = NULL WHERE userId = $userId");
       // set cookie for 10 years ago to delete it 
       setcookie('rememberme', "delete me cookie", 
       
       time() - (3600 * 3650), "/", ".sewanee.edu");
       
     }
  } // end deleteRememberMeCookie
  
  
  
  
  
  
  
  
  
  
  
  public function doLogout()
 
  { 
    // delete cookie, reset SESSION array, destroy session, 
    // set user logged in to false, and tell user they have been logged out
    $this->deleteRememberMeCookie();
    $_SESSION = array();
    session_destroy();
    $this->user_is_logged_in = false;
  } // end doLogout()
  
  
  
  
  
  
  
  
  
  
  
  public function isUserLoggedIn()
  {
  
    return $this->user_is_logged_in;
    
  } // end user is logged in 
  

  private function getUserData($user_email) {
    
    if($this->databaseConnection()) {
      
      
      
      $does_user_exist = $this->conn->query
      
      ("SELECT * FROM artistLogin WHERE email = '$user_email'");
      
      
      // returns either a query result object or false 
      // might need to return result row as an object 
      // ($result_row = $query_user->fetchObject();)  

      $object = $does_user_exist->fetch_object();
      return $object;
      
    }
  }
  
  
  
  // $this->setPasswordResetDatabaseTokenAndSendMail($_POST['user_email']);
  public function setPasswordResetDatabaseTokenAndSendMail($user_email) 
  
  {
    
    $user_email = trim($user_email);
    // write the user_email into this session for access later 
    // when we need to verify passwords
    $_SESSION['user_email'] = $user_email;
    
    if (empty($user_email)) { $this->errors[] = "The message email is empty";  }
    
    // generate timestamp (to see when exactly the user (or hacker)
    // requested the password reset mail)
    
    $userPassResetTimestamp = time();
    
    // generate random hash for email password reset verification (40 char string)
    $userPassResetHash = sha1(uniqid(mt_rand(), true));

    // database query, getting all the info of the selected user
    $result_row = $this->getUserData($user_email);

     
     
    // if user exists 
    if (isset($result_row->userId)) 
    {

      $userId = $result_row->userId;
      
      
      // query db for passResetHash and the PassresetTimestamp
      $setPassResetHashAndPassResetTimestamp = $this->conn->query
      
      ("update artistLogin set userPassResetHash = '$userPassResetHash',
      
      userPassResetTimestamp = '$userPassResetTimestamp' 
      
      where userId = '$userId'");  
      
      
      // check if exactly one row was successfully changed:
      if ($setPassResetHashAndPassResetTimestamp) 
      {

        // send a mail to the user, containing a link with that token hash string
        $this->sendPasswordResetMail($result_row->email
                                    ,$userPassResetHash);
                                    

        return true;
      }
      else 
      {
        $this->errors[] = "The query affected no or more than one rows";
      } 
    }
    else 
    {
      $this->errors[] = "This user doesn't exist";
    }
    // return true only when the database is successfully updated
    return false;   
  }


  
  
  
  
  public function sendPasswordResetMail($user_email
                                       ,$userPassResetHash)
  {
  
    // create messgae to send
    $message = Swift_Message::newInstance();
  
    $message->setSubject('Haiti Account Activation');
    $message->setTo(array("$user_email" => "Hello"));
    $message->setFrom(array('evansdb0@sewanee.edu' => 'Haiti Customer Service'));
    
    // send them a link with their email and the password hash encoded in the url
    $link    = 'http://hive.sewanee.edu/evansdb0/pp/password_reset.php'
    
    .'?user_email='.urlencode($user_email).'&verification_code='.urlencode
    
    ($userPassResetHash); 
    
    $message->setBody
    ("\nClick <a href='$link'>here</a> to reset your password",'text/html');
    
    $transport = Swift_MailTransport::newInstance();
  
    $mailer = Swift_Mailer::newInstance($transport);
  
    $result = $mailer->send($message);
  
    if(!$result) { $this->errors[] = "message not sent"; return false; } 
    
    else { 
      $this->messages[] = "Check you email for a password reset link"; 
      return true; 
    } 
  } // end sendPasswordResetMail()
  
  // $this->checkIfEmailVerificationCodeIsValid
  // ($_GET["user_email"],$_GET["verification_code"]);
  public function checkIfEmailVerificationCodeIsValid($user_email, $verification_code)
  
  {
  
    $_SESSION['user_email'] = $user_email;

    $user_email = trim($user_email);
    
    if(empty($user_email) || empty($verification_code)) {
      $this->errors[] = "Link parameters are empty";
    }
    else {
    
      
      
      $result_row = $this->getUserData($user_email);
      
      
    }
    // if this user exists and the verification code 
    // has the same hash in the database
    if(isset($result_row->userId) && 
             $result_row->userPassResetHash == $verification_code) 
    {
      
      $timestamp_1_hour_ago = time() - 3600;
      
      
      // if the time stamp in the database is <= one hour old 
      if ($result_row->userPassResetTimestamp > $timestamp_1_hour_ago) {

        $this->password_reset_link_is_valid = true;
      }
      else {
        $this->errors[] = "The message reset link has expired";
      } 
    }
    else 
    {
      $this->errors[] = "This user does not exist or the passHashes don't match";
    }
  } // end checkIfEmailVerificationCodeIsValid() 
  
  public function ResetUserPassword($user_password_new
                                   ,$user_password_repeat) 
                                  
  {
    if (empty($user_password_new)    || 
        empty($user_password_repeat) ) {
        
      $this->errors[] = "One of the password fields is empty";
      $this->resetPass = false;
    } 
    elseif ($user_password_new !== $user_password_repeat) {
      $this->errors[] = "The new password and confirm password fields don't match";
      $this->resetPass = false;
    }
    elseif (strlen($user_password_new) < 6) {
      $this->errors[] = "The new password is too small";
      $this->resetPass = false;
    }
    else 
    {
      
      // get hash of currently logged in user (to check with just provided password)
      // maybe turn into a post[''] since the hidden field has the user's email
      $result_row = $this->getUserData($_SESSION['user_email']);
      // if the user exists 
      if (isset($result_row->passHash)) {

        // hash the new password the user inputted
        $passHash = password_hash($user_password_new
                                 ,PASSWORD_DEFAULT);
          
          
        $email = $_SESSION['user_email'];
        // write new password to the database
        $save_new_password = $this->conn->query
        
        ("UPDATE artistLogin SET passHash = '$passHash' 
         
        WHERE email = '$email'");
          
        // will this be greater than 1?? when will it be < 1???
        // check if exactly one row was changed 
        if($save_new_password) {
         
          $this->messages[] = "New password saved succesfully";
          $this->resetPass = true;
          $this->password_reset_was_successful = true;
        }
        else 
        {
          $this->errors[] = "The update affected > 1 row ";
        }
      }  // end user exists
      else 
      {
        $this->errors[] = "This user does not exist";
      } 
    } // end else 
  } // end editUserPassword()
 
 
 
 
 
 
 
 
 
 
  public function passwordResetWasSuccessful()
  {
    return $this->password_reset_was_successful;
  } // end passwordResetWasSuccessful()
  public function passReset() {
    return $this->resetPass;
  }
  public function passwordResetLinkIsValid()
  {
    return $this->password_reset_link_is_valid;
  }
  public function getEmail()
  {
    return $this->user_email;
  }

      
} // end class 
?>

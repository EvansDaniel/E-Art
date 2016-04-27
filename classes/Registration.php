<?php 


require_once('swiftmailer/lib/swift_required.php');
  ini_set('display_errors', 1);
  error_reporting(E_ALL);


class Registration 
{
  
  private $USER_UPLOAD_PATH = '/home/evansdb0/html/';
  
  private $conn = null;
  
  public  $registration_successful = false;
  
  public  $verification_successful = false;
 
  public  $errors = array();
  
  public  $messages = array();

  public function __construct()
  {
    session_start();
   
    // if we have such a POST request, call the registerNewUser() method
    if (isset($_POST["submit"])) {
    
      // TODO: need to perform html sanitation on these post variable
      $this->registerNewUser($_POST['UserName']
                            ,$_POST['EmailAddress']
                            ,$_POST['Password']
                            ,$_POST['ConfirmPassword']
                            ,$_POST['FirstName']
                            ,$_POST['isArtist']
                            ,$_POST['College']); 


                            
      // if we have such a GET request, call the verifyNewUser() method
    } else if (isset($_GET["id"]) && 
               isset($_GET["verification_code"])) 
    {
        $this->verifyNewUser($_GET["id"]
                            ,$_GET["verification_code"]);
    }  
    
  }
  

  private function databaseConnection()
  
  {
    // if connection already exists
    if ($this->conn != null) {
      return true;
    } 
    else {
           
      $this->conn = new mysqli("crisler.sewanee.edu"
                              ,"user"
                              ,"csci"
                              ,"eArt");  
      // throw error if conn fails
      if ($this->conn->connect_error) {
        die($this->conn->connect_error); 
        return false;
      }
      return true;
    }
    return false; 
  } // end dbConnection 
  
  
  // ----------------------------------------------------------------------------------
  
  
  
  // handles the entire registration process. checks all error possibilities 
  // and creates a new user in the database if everything is fine
  /*
     $this->registerNewUser($_POST['UserName']
                            ,$_POST['EmailAddress']
                            ,$_POST['Password']
                            ,$_POST['ConfirmPassword']
                            ,$_POST['FirstName']
                            ,$_POST['isArtist']
                            ,$_POST['College']); 
  */
 private function registerNewUser($user_name
                                  ,$user_email
                                  ,$user_password
                                  ,$user_password_repeat
                                  ,$fName
                                  ,$isArtist
                                  ,$college)
  


  {   
    
    // check provided data validity
    // check length and matching passwords
    if (empty($user_password) || empty($user_password_repeat)) {
        $this->errors[] = 'The password is empty';
    } elseif ($user_password != $user_password_repeat) {
        $this->errors[] = "The password fields do not match";
    } elseif (strlen($user_password) < 6) {
        $this->errors[] = "The password isn't long enough";
        
      // check length and validity of the email address and username
    } elseif(empty($user_name)) {
        $this->errors[] = "The username field is empty";
    } elseif (strlen($user_name) > 20) {
        $this->errors[] = "The username is too long";
    } elseif (empty($user_email)) {
        $this->errors[] = "The email field is empty";
    } elseif (strlen($user_email) > 50) {
        $this->errors[] = "The email entered is too long";
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $this->errors[] = "The email you entered is invalid";
      // check length of first name
    } elseif (strlen($fName)==0 || strlen($fName) > 25) {
        $this->errors[] = 
        "The first name field is either empty or too long ". strlen($fname);
      // check length of last name 
    } elseif(isset($college) && strlen($college) > 75) {
        $this->errors[] = "The college field is too long";
      }
    // all verifications good 
    elseif ($this->databaseConnection()) {
    
      $fName = trim($fName);

      
      // TODO: sanitize user input or use prepare statement
      // removes all dashes, whitespace, and parens from phone number

      // TODO: make this a prepare statement 
      $checkForEmail = 
        
      "select email from people where email = '$user_email'";
      
      // store result 
      $r = $this->conn->query($checkForEmail);
      
      $checkUserName = 
        
      "select userName from people where userName = '$user_name'";
      
      $res = $this->conn->query($checkUserName);

      // ensures userNames are unique
      if(true) { // $res->num_rows < 1
        // ensures emails are unique
        if(true) {  // $r->num_rows < 1
          $pass_hash = password_hash($user_password, PASSWORD_DEFAULT);
          $activateAccountHash = sha1(uniqid(mt_rand(), true));
          $date = date("Y-m-d H:i:s");

          // write users information into the database

          // later on these "people" will be turned into artists
          // and/or buyers by the act of buying something 
          // or placing something on his or her store
          $new_people_insert = 0;
          
          if(isset($isArtist) && $isArtist == 1) {

            if(isset($college)) {

              $q = "insert into artists(college) 

              VALUE('$college')"; 

              $this->conn->query($q);

              // get auto-generated id from last insert        
              $user_id = $this->conn->insert_id; 

              $new_people_insert = $this->conn->query
          
          ("insert into people(userName,passHash,email,fName,isArtist,artistId)
          
          VALUES('$user_name','$pass_hash','$user_email','$fName','1',

          (select artistId from artists where artistId='$user_id'))");

              $q = "create table " . $user_name . "Orders(
                orderId int unsigned not null auto_increment primary key,
                peopleId int,
                itemId int,
                addressId int,
                dateOfBuy date,
                isShipped tinyint(1) unsigned,
                isDelivered tinyint(1) unsigned

              )"; 

                $this->conn->query($q);
    
                echo "<br><br><br>";
            
            if(!$new_people_insert) echo $this->conn->error;

            }
            else {
              $errors[] = "You didn't enter a college";
              return;
            }
          }
          else {
            $new_people_insert = $this->conn->query
          
            ("insert into people(userName,passHash,email,fName)
          
            VALUES('$user_name','$pass_hash','$user_email','$fName')");

            $user_id = $this->conn->insert_id;

          }
          $q = "create table " . $user_name . "Addresses(
            addressId int unsigned not null auto_increment primary key,
            address varchar(100)

          )"; 
          $this->conn->query($q);
          
          if($new_people_insert) {
            /*

Notice: Undefined property: Registration::$con in /var/www/html/evansdb0/eArt/classes/Registration.php on line 225

Notice: Trying to get property of non-object in /var/www/html/evansdb0/eArt/classes/Registration.php on line 225

            */

          
            


            if($this->sendVerificationEmail($user_id
                                           ,$fName
                                           ,$user_email
                                           ,$activateAccountHash)) 
            {
              $this->messages[] = "<p color= 'white' font-size='2em'>Check your email for a verification email
              to activate your account<p>";
              $this->registration_successful = true;
            } 
            else {
           
              // delete user because we could not send a verification email
              $delete_new_user = $this->conn->query
              ("delete from people where peopleId = '$user_id'");
            
              // reset the auto_increment to the proper
              $delete_new_user = $this->conn->query
              ("Alter table people AUTO_INCREMENT = '$user_id'");  
             
              $this->errors[] = "Failed to send the verification email";
            }
          } 
          else {
              
              $this->errors[] = "Failed registration";
          }
        }
        else {
          $this->errors[] = "This email is already taken";
        }
      } 
      else {
        $this->errors[] = "This username is being used already. Try a different one.";
      }     
    }
    // make a directory just for this user's uploaded photos
    if($this->registration_successful) {
    
      // TODO: need to make the userName unique
      // make a directory for uploads      
      // make a session variable out of their username -> this happens in login -> add
      // a query for retrieving the username and store in session variable ->
      // then use it that session variable with the absolute path
      
      $path = $this->USER_UPLOAD_PATH;

      $this->USER_UPLOAD_PATH . $user_name; 
      // run shell mkdir command to make a users directory     
      shell_exec("mkdir ../" . $user_name);
      
    }
  }  // end registerNewUser function  
  

//-----------------------------------------------------------------------------------------

  
  public function sendVerificationEmail($user_id
                                       ,$fName
                                       ,$user_email
                                       ,$activateAccountHash) 
                                       
  {  
  
    // create messgae to send
    $message = Swift_Message::newInstance();
  
    $message->setSubject('Account Activation');
    $message->setTo(array("$user_email" => "Hello"));
    $message->setFrom(array('evansdb0@sewanee.edu' => 'Haiti Customer Service'));
    
    $link = "http://hive.sewanee.edu/evansdb0/eArt/SignUp.php".
    
                      "?id=" . urlencode($user_id) . "&verification_code="
                      
                      . urlencode($activateAccountHash);
    
    $message->setBody
    
    ("<pre><p style='font-family: Times New Roman; font-size: 14px'>Dear $fName,\n
We would like to thank you for signing up for our website.
If you have any trouble, call our customer service at 555-5555-555.
\nClick ". "<a href='$link'>here</a>" . " to verify your account. Hope you enjoy! \n 
Best regards,

Daniel Evans</p></pre>"
,'text/html');
  
    $transport = Swift_MailTransport::newInstance();
  
    $mailer = Swift_Mailer::newInstance($transport);
  
    $result = $mailer->send($message);
  
    if(!$result)  return false; else return true; 
 
  } // end sendVerificationEmail function 
    
  
  public function verifyNewUser($user_id, $activateAccountHash)
  
  {
    

    // if database connection opened
    if ($this->databaseConnection()) {
      
      $update_new_user = $this->conn->query
      
      ("update people set userActive = 1, userActiveHash = '$activateAccountHash'
      
      where peopleId = '$user_id'");
      
      if(!$update_new_user) echo $this->conn->error;
      
      if($update_new_user) {
        
        $this->verification_successful = true;
        
        // calls a javascript function that redirects user to 
        // the home page and uses a nice animated countdown
        echo "<p id='verify'>
        The email verification was successful. You will be redirected in 
        <span id='counter'>5</span> second(s).
        </p> <script type='text/javascript'>
              setInterval(function(){ countdown(); },1000);
             </script>
        <p>If you are not redirected, click <a href='pHome.php'>here</a></p>";
      }
      else 
      {
        $this->errors[] = 'The verification has failed';
      }
    } 
    
  }  // end verifyNewUser function  
} // end class   



?>


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
    
      // TODO: need to perform html sanitation on these post variables
      $this->registerNewUser($_POST['UserName']
                            ,$_POST['EmailAddress']
                            ,$_POST['Password']
                            ,$_POST['ConfirmPassword']
                            ,$_POST['FirstName']
                            ,$_POST['LastName']
                            ,$_POST['University']);  
                            
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
  
  
  // ----------------------------------------------------------------------------------
  
  
  
  // handles the entire registration process. checks all error possibilities 
  // and creates a new user in the database if everything is fine
 private function registerNewUser($user_name
                                  ,$user_email
                                  ,$user_password
                                  ,$user_password_repeat
                                  ,$fName
                                  ,$lName
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
    } elseif (strlen($lName)==0 || strlen($lName) > 25) {
        $this->errors[] = 
        "The last name field is either empty or too long ". strlen($lName);
        
      // check length of career
    } elseif (strlen($college) > 25) {
        $this->errors[] = "The career field is too long ". strlen($career);
    } elseif(empty($college)) {
        $this->errors[] = "The career field is empty";
    }
    
    
    // all verifications good 
    elseif ($this->databaseConnection()) {
    
      $fName = trim($fName);
      $lName = trim($lName);
      
      // TODO: sanitize user input or use prepare statement
      // removes all dashes, whitespace, and parens from phone number

      // TODO: make this a prepare statement 
      $checkForEmail = 
        
      "select email from artistLogin where email = '$user_email'";
      
      // store result 
      $r = $this->conn->query($checkForEmail);
      
      $checkUserName = 
        
      "select userName from artistLogin where userName = '$user_name'";
      
      $res = $this->conn->query($checkUserName);

      
      // if there is no other email like this one ($r->num_rows < 1) &&
      // ensures userNames are unique $res->num_rows < 1
      if(true) {
        // ensures usernames are unique
        if(true) {
          $pass_hash = password_hash($user_password, PASSWORD_DEFAULT);
          $activateAccountHash = sha1(uniqid(mt_rand(), true));
          $date = date("Y-m-d H:i:s");
          
          // TODO: tag table & category & address = general, orders
          $artistItemTableName = $user_name . "Items";
          
          // create the tables for the artist's products and orders
          $query = "create table $artistItemTableName(
                    itemId     int unsigned not null auto_increment primary key,
                    name       varchar(50),
                    artistId   int,
                    categoryId int,
                    price      int,
                    description varchar(1000), 
                    fiTag      int,
                    sTag       int,
                    thTag      int,
                    imgPath    varchar(100),
                    inStock    tinyint(1),
                    productRank int
                   
                    )";
           // run create table query
           $r = $this->conn->query($query);
           if(!$r) echo $this->con->error;
           
          $artistOrdersTableName = $user_name . "Orders"; 
          $query = "create table $artistOrdersTableName(
          
                    orderId   int unsigned not null auto_increment primary key,
                    itemId    int,
                    shippingAddress varchar(80),
                    date      date,
                    shipped   tinyint(1),
                    delivered tinyint(1)
                   
                    )";
           // run create table query
           $r = $this->conn->query($query);
           if(!$r) echo $this->con->error;
                   

          // write users information into the database
          $new_artistLogin_insert = $this->conn->query
          
          ("insert into artistLogin(userName,passHash,email,fName,lName,college)
          
          VALUES('$user_name','$pass_hash','$user_email','$fName','$lName','$college')");
          
          if(!$new_artistLogin_insert) echo $this->conn->error;
          

        
          // get auto-generated id from last insert        
          $user_id = $this->conn->insert_id; 
          if($new_artistLogin_insert) {

            if($this->sendVerificationEmail($user_id
                                           ,$fName
                                           ,$lName
                                           ,$user_email
                                           ,$activateAccountHash)) 
            {
            
              $this->messages[] = "Check your email for a verification email
              to activate your account";
              $this->registration_successful = true;
            } 
            else {
           
              // delete user because we could not send a verification email
              $delete_new_user = $this->conn->query
              ("delete from artistLogin where artistId = $user_id");
            
              // reset the auto_increment to the proper
              $delete_new_user = $this->conn->query
              ("Alter table artistLogin AUTO_INCREMENT = $user_id");  
             
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
      
      if (mkdir($path . $user_name ,0777)) {
      }
      else {
        $this->errors[] = "There was a problem making the directory ";
        var_dump(file_exists($path . $user_name));
      }
    }
  }  // end registerNewUser function  
  

//-----------------------------------------------------------------------------------------







  
  public function sendVerificationEmail($user_id
                                       ,$fName
                                       ,$lName
                                       ,$user_email
                                       ,$activateAccountHash) 
                                       
  {  
  
    // create messgae to send
    $message = Swift_Message::newInstance();
  
    $message->setSubject('Account Activation');
    $message->setTo(array("$user_email" => "Hello"));
    $message->setFrom(array('evansdb0@sewanee.edu' => 'Haiti Customer Service'));
    
    $link = "http://hive.sewanee.edu/evansdb0/pp/SignUp.php".
    
                      "?id=" . urlencode($user_id) . "&verification_code="
                      
                      . urlencode($activateAccountHash);
    
    $message->setBody
    
    ("<pre><p style='font-family: Times New Roman; font-size: 14px'>Dear $fName $lName,\n
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
      
      ("update artistLogin set userActive = 1, userActiveHash = '$activateAccountHash'
      
      where artistId = '$user_id'");
      
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


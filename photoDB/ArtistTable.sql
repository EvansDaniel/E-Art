drop tables artistProfile, artistLogin;
/*
  @userId the unique id of each user that signs up 
  
  @passHash the unique hashed password for each user

  @email the email of each user
  
  @lastLoginTime the time at which the user last logged in (is this useful?)
  
  @userActive 1 if the user has activated his/her account via email, null otherwise
  
  @userActiveHash the hashed email verification code
  
  @rememberMe 
  
  @userPassResetHash user's password reset verification code
  
  @userPassResetTimestamp the time at which the user requested a password reset
*/
create table artistLogin (  
  
  artistId               int unsigned not null auto_increment primary key,
  userName               varchar(20),
  passHash               char(255),
  email                  varchar(50),
  fName                  varchar(25), 
  lName                  varchar(25),
  college                varchar(25),
  userActive             tinyint(1) unsigned,
  rememberMe             varchar(64),
  userPassResetHash      varchar(40),
  userPassResetTimestamp bigint(20),
  userActiveHash         varchar(30)
  
);


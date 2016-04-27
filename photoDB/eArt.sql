/*
  Daniel Evans and Blaise Iradukunda
  April 18, 2016 
  MySql table creations and insertions
 
*/

drop database eArt;
create database eArt;
use eArt;
/*
  
  @userActive 1 if the user has activated his/her account via email, null otherwise
  
  @userActiveHash the hashed email verification code sent to user to verify account
  
  @rememberMe The information in the cookie if remember me is set at time of login
  
  @userPassResetHash user's password reset verification code
*/
drop table artists;
create table artists(
  
  artistId int unsigned not null auto_increment primary key,
  college varchar(75),
  biography varchar(1000),
  profilePicPath varchar(150),
  peopleId int

);
/*
create table buyers(
  buyerId int unsigned not null auto_increment primary key,
  defaultShippingAddressId int,
  cardNumber varchar(19),
  cardExpirationDate date,
  cardSecurityNum smallint(3),
  peopleId int
);

create table people(  
  
  peopleId               int unsigned not null auto_increment primary key,
  userName               varchar(20),
  passHash               char(255),
  email                  varchar(50),
  fName                  varchar(25),
  userActive             tinyint(1) unsigned,
  rememberMe             varchar(64),
  userPassResetHash      varchar(40),
  userActiveHash         varchar(30),
  buyerId                int,
  artistId               int
);
*/
drop table people;
create table people(  
  
  peopleId               int unsigned not null auto_increment primary key,
  userName               varchar(20),
  passHash               char(255),
  email                  varchar(50),
  fName                  varchar(25),
  lName                  varchar(25),
  userActive             tinyint(1) unsigned,
  rememberMe             varchar(64),
  userPassResetHash      varchar(40),
  userActiveHash         varchar(30),
  shippingAddressId      int,
  cardId                 int,
  isArtist               tinyint(1),
  artistId               int

);

/*
create table orders( 
  
  orderId int unsigned not null auto_increment primary key,
  buyerId int,
  itemId int,
  defaultShippingAddressId int,
  dateOfBuy date,
  isShipped tinyint(1) unsigned,
  isDelivered tinyint(1) unsigned

  );
*/
drop table category;
create table category (

  categoryId int not null auto_increment primary key,
  category varchar(30)

);
ALTER TABLE category add FULLTEXT(category);


create table address(
  
  defaultShippingAddressId int unsigned  not null auto_increment primary key,
  defaultShippingAddress varchar(200)
  
);

/* this will make searches more effective when buyers search for products */
drop table tags;
create table tags (
  
  tagId   int unsigned not null auto_increment primary key,
  tagName varchar(30)
  
);
ALTER TABLE tags add FULLTEXT(tagName);

create table category (
  
  categoryId   int unsigned not null auto_increment primary key,
  category     varchar(30)
  
);

/* 

 this table is create when the artist registers as well 

 It will contain the information for each artists' products

 @artistItemTableName this is the artist's userName concatenated with "Orders".

 @fiTag, sTag, thTag these are the 1st, 2nd & 3rd required tags to help the search 

 @imgPath this is the path on the server to the images of the products 
 the artist puts on the site

 @inStock a flag that qualifies each product when we query the database to 
 generate the product listing. It will be "false" (0) when a user buys the item.
 This way it is easy to delete sold items

 @productRank this is a randomized number between 1 and 1000 that will be used to 
 calculate the top 10 artists. The formula for that is the sum of the product ranks 
 of all of each artists' items divided by the number of items. The best 10 avg. make
 it in the top 10 artists of the month. Later, there would hypothetically be professional
 artists to critique and rate each piece.

*/
drop table products;
create table products(

  itemId      int unsigned not null auto_increment primary key,
  name        varchar(50),
  artistId    int,
  categoryId  int,
  price       int,
  description varchar(1000), 
  tagId1      int,
  tagId2      int,
  tagId3      int,
  imgPath     varchar(100),
  inStock     tinyint(1),
  productRank int

);
ALTER TABLE products add FULLTEXT(name);
ALTER TABLE products add FULLTEXT(description);
/* DON'T CHANGE THIS ORDER --- IT IS IMPERATIVE FOR THE ORDERING OF THE 

CATEGORIES --- IF CHANGED IT AFFECTS ----------> addNewProducts.php
*/

insert into category(category) VALUE("photography");
insert into category(category) VALUE("painting");
insert into category(category) VALUE("sculptures");
insert into category(category) VALUE("videos");

/*

 insert into tags(tagName) VALUE("Cappella Magna");
 insert into tags(tagName) VALUE("church painting");
 insert into tags(tagName) VALUE("Italy"); 

 insert into tags(tagName) VALUE("portrait");
 insert into tags(tagName) VALUE("painting");
 insert into tags(tagName) VALUE("Leonardo Da Vinci");

 insert into category(category) VALUE("painting");

 sample inserts: (the passHash is hashed using the password_hash() php function) 


insert into people(userName
                  ,passHash
                  ,email
                  ,fName
                  ,buyerId
                  ,artistId)

  VALUES("evansdb0"
        ,"sewanee"
        ,"evansdb0@sewanee.edu"
        ,"Daniel"
        ,NULL /* NULL because this person registered at first as an artist 
        ,1
        );

insert into artists(college
                  ,biography
                  ,profilePicPath
                  )

  VALUES("University of the South"
        ,"I am the best artist in the world"
        ,"/home/evansdb0/html/artists/evansdb0/mypic.php"
        );

/*
 given the above insertion, we would know have a table named evansdb0Items   
 So assuming I head over to the addNewProduct.php page and submit a form,
 here is a test

  the artistId is stored in a session variable

  the categoryId helps with searching for products because we 
  will require users to select a field in a drop down menu next to the search bar 
  (similar to Amazon)

  productRank is generated via mt_rank(1,10000);


insert into products(name,
                     artistId,
                     categoryId,
                     price,
                     description,
                     tagId1,
                     tagId2,
                     tagId3,
                     imgPath,
                     inStock,
                     productRank)

  VALUES("The Sistine Chapel",
         1,
         (select categoryId from category where category = "painting"),
         987654321,
         "This painting is literally awesome",
         (select tagId from tags where tagName = "Cappella Magna"),
         (select tagId from tags where tagName = "church painting"),
         (select tagId from tags where tagName = "Italy"),
         "home/evansdb0/eArt/artists/evansdb0/helloworld.png",
         1,
         9999
         );

insert into products(name,
                     artistId,
                     categoryId,
                     price,
                     description,
                     tagId1,
                     tagId2,
                     tagId3,
                     imgPath,
                     inStock,
                     productRank)

  VALUES("Mona Lisa",
         1,
         (select categoryId from category where category = "painting"),
         123456789,
         "This painting is literally better than awesome",
         (select tagId from tags where tagName = "portrait"),
         (select tagId from tags where tagName = "painting"),
         (select tagId from tags where tagName = "Leonardo Da Vinci"),
         "home/evansdb0/eArt/artists/evansdb0/mona_lisa.png",
         0,
         9998
         ); 


tagId | tagName     |
+-------+-------------+
|     1 | space       |
|     2 | wars        |
|     3 | time        |
|     4 | london      |
|     5 | thames      |
|     6 | big ben     |
|     7 | clone       |
|     8 | evil        |
|     9 | star wars   |
|    10 | jets        |
|    11 | gray sky    |
|    12 | sun         |
|    13 | life        |
|    14 | cities      |
|    15 | streets     |
|    16 | gray skies  |
|    17 | flying  
         */

insert into tags(tagName) VALUE('space');
insert into tags(tagName) VALUE('war');
insert into tags(tagName) VALUE('time');
insert into tags(tagName) VALUE('london');
insert into tags(tagName) VALUE('thame');
insert into tags(tagName) VALUE('big ben');
insert into tags(tagName) VALUE('clone');
insert into tags(tagName) VALUE('evil');
insert into tags(tagName) VALUE('star war');
insert into tags(tagName) VALUE('jet');
insert into tags(tagName) VALUE('yarg yks');
insert into tags(tagName) VALUE('sun');
insert into tags(tagName) VALUE('life');
insert into tags(tagName) VALUE('ytic');
insert into tags(tagName) VALUE('street');
insert into tags(tagName) VALUE('yarg yks');
insert into tags(tagName) VALUE('flying');


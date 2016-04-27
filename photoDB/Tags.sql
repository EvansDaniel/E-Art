
/*
  Tables left to create at some point: 
  
  Buyers table 
  buyingTrends

*/

create table tags (
  
  tagId   int unsigned not null auto_increment primary key,
  tagName varchar(30)

);

create table category (
  
  categoryId   int unsigned not null auto_increment primary key,
  category   varchar(30)

);

create table address (
  
  defaultShippingAddressId int unsigned not null auto_increment primary key,
  defaultShippingAddress   varchar(60)  
);

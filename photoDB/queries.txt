/*
  Daniel Evans and Blaise Iradukunda
  April 18, 2016 
  MySql queries

*/

/*

  this gets the all the items that haven't been sold in a 
  certain category (we will display these items to the user when searched)

*/

select name,price,description,imgPath from products 

where inStock='1' and categoryId='1';


/* the '1' for artistId is saved in a session variable when the artist logs in 
   this query will get the orders that that artist needs to fulfill

   inStock = 0 -> someone bought this product
*/

select name,price from products where artistId ='1' and inStock='0';


/* 

This query will get the products in the artists store

*/
select name,price,description,imgPath from products where artistId ='1' and inStock='1';



/* 

This query will get the items from the products table 
when a buyer searches "Italian painting" 

-> We will run the search keywords through a toLowercase function along 
-> with the various tags added to products

*/

select name from products where categoryId ='1' and ((select tagId from tags where tagName like 


"%italian%" limit 1) or (select tagId from tags where tagName like 


"%painting%" limit 1));



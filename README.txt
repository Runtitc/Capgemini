This project consists of SIX .php file, one .sql with database structure and one for .css styles. 
- crud.sql - I set up the Database with the name 'crud' on the phpmyadmin (via web server XAMPP), 
	the code to create the database. This file was exported from phpmyadmin and it includes the whole structure to create a database, 
	table and sample data insertion. 
- Database.php - It defines the class to handle all the things related to the database connections. Connection is made with PDO in order to easier 
  the connection with other databases than only one MySQL, e.g with PostgreSQL.
  
- index.php - in this file I comprehended  the table showing the whole array where the datas are stored. In the body tag I included the Database.php
  file and executed the static Connection method. After the connection is made, I make a SELECT query that finds all the rows in the table, next I
  loop through all the results (foreach type of loop goes through all the rows in the result of query) and I echo all the datas from the database (besides the id)
  with the TR tags. I also added addition column with hyperlinks to the option for each row to read, delete or update them. To make the table more clear
  I used the bootstrap to highlight the particular row when I hover on it (that is why there are additional scripts and links in the head tag)
  
 - create.php - Here In most cases I commented the rows that I think could be confusing. I used htmlspecialchars() in a form to prevents the attackers
   from exploiting the code by injecting the HTML or JS code. Next, I used the POST method to send the datas. Additionaly, I made easy validation at the form and when someone types wrong
   datas, the create function will not pass. I hope I didn't forget about some circumstances :)
 
 - read.php - If you click on a Read hyperlink at the particular row, then you send the ID with a GET method to the read.php page. Here you detect if there was
   a kind of GET method send, if not there is a redirection to index.php, for instance, if you just enter the webpage+read.php or even read.php?id= with id equal to
   the non existing in a datbase ID number, then you will be redirected to the index.php. The same method I did in the update.php and delete.php file. Next,
   if variables like  " $data['Name'] " and so on, exists, then they will appear at the particular fields. The last thing I would mention here is the prepared statements,
   (prepare and afterwards execute the statemant-> the array at execute function sends consecutive variables to the consecutive '?' at the query statements), 
   I used it to protect from SQL incjection. At the end I fetched all the datas in a particular row to the $data variable in a FETCH_ASSOC mode, so I have an access to them
   via the name (e.g not the number or an array or something like that)
 
 - delete.php - in that file I used almost the same method as in the read.php file. One particular difference is that I use the Delete query. Additionaly I
   used alternative syntax for control structures - COLON. I decided to use it instead of making a new file with html code and include it depending on the given condition.
   
 - update.php - here are almost the same method as in the previous files. 
 
 At the .css file I added the styles to the top menu.
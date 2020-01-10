# C.R.U.D.-web-app
This is a PHP website that allows the user to perform C.R.U.D (Create,Read,Update,Delete) operations on a list of users fetched from a MySql database.Bootstrap was also used for the css. 
 
 You cannot acces the main page if you havent logged first. You can log in with username : _admin_ and password : _admin_.
 
 Once logged you will be on _index.php_  where you can see all your users fetched from the database.
 
 I worked on _index.php_ and _dbh.inc.php_ .
 
 
 _dbh.inc.php_ purpose is to make, close the connection to the database and to fetch the users from it.
 
 # How to install
 1. Download the repository on your computer and  Download [WAMP](https://sourceforge.net/projects/wampserver/)
 2. Open mysql workbench, create a database named tp_user with help of the tp_user.sql file in the database folder of the project
 3. Add the project in your virtual host. If you dont have, create one.
 4. Open the repository in your virtual host
 

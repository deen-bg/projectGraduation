<?php
require_once("../database/Db.php");
$objDb = new Db();
$db = $objDb->database;

try {
	    //Create database//
	    $sql = "CREATE DATABASE myproject";
	    // use exec() because no results are returned
	    $db->exec($sql);
	    echo "Database created successfully<br>";
    }
    catch(PDOException $e)
    {
    	echo $sql . "<br>" . $e->getMessage();
    }
    	//End Create database//

try{
	// sql to create table admin
	$sql = "CREATE TABLE admin (
			admin_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
			username VARCHAR(40) NOT NULL, 
			password VARCHAR(40) NOT NULL )";
			
			// use exec() because no results are returned
			$db->exec($sql);
			echo "admin table created successfully";
			echo "<br>";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//End sql to create table admin

	// sql to create table customer
try{
	$sql = "CREATE TABLE customer (
			cus_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			cus_name VARCHAR(50) NOT NULL,
			cus_surname VARCHAR(50) NOT NULL,
			cus_gender VARCHAR(50) NOT NULL,
			cus_mail VARCHAR(50) NOT NULL,
			cus_phone VARCHAR(50) NOT NULL,
			cus_add VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "customer table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
?>
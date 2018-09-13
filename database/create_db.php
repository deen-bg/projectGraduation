<?php
require_once("../database/Db.php");
$objDb = new Db();
$db = $objDb->database;

try {
	    //Create database name//
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
			echo "<br>";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//End sql to create table customer

	// sql to create table raw material
	try{
	$sql = "CREATE TABLE rawmaterial (
			matr_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			matr_impdate date NOT NULL,
			matr_name VARCHAR(50) NOT NULL,
			matr_quantity VARCHAR(50) NOT NULL,
			matr_price VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "material table created successfully";
			echo "<br>";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//End sql to create table material

	// sql to create table inventory
	try{
	$sql = "CREATE TABLE inventory (
			invent_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			invent_instock VARCHAR(50) NOT NULL,
			invent_date date NOT NULL,
			invent_amount VARCHAR(50) NOT NULL,
			invent_price VARCHAR(50) NOT NULL,
			invent_status VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "inventory table created successfully";
			echo "<br>";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//End sql to create table inventory

	// sql to create table product
	try{
	$sql = "CREATE TABLE product (
			product_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			product_name VARCHAR(50) NOT NULL,
			product_price VARCHAR(50) NOT NULL,
			product_status VARCHAR(50) NOT NULL,
			product_amount VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "product table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//End sql to create table product
?>
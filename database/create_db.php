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

	//Create table product model//
	try{
	$sql = "CREATE TABLE productModel (
			pmodel_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			pmodel_name VARCHAR(50) NOT NULL,
			pmodel_desc VARCHAR(50) NOT NULL,
			pmodel_img VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "product Model table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END//

	//create staff table
	try{
	$sql = "CREATE TABLE staff (
			staff_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			staff_name VARCHAR(50) NOT NULL,
			staff_surname VARCHAR(50) NOT NULL,
			staff_passportid VARCHAR(50) NOT NULL,
			staff_add VARCHAR(50) NOT NULL, 
			staff_stwd date NOT NULL,
			staff_phone VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "Staf table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END//
	//create seller//
	try{
	$sql = "CREATE TABLE sell (
			sell_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			sell_date date NOT NULL,
			sell_price VARCHAR(50) NOT NULL,
			sell_amount VARCHAR(50) NOT NULL,
			sell_total VARCHAR(50) NOT NULL, 
			sell_status VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "Selling table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END
	//create delivery table
	try{
	$sql = "CREATE TABLE delivery (
			deliver_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			deliver_date date NOT NULL,
			deliver_amount VARCHAR(50) NOT NULL,
			deliver_by VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "Delivery table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END

	//create table product defective
	try{
	$sql = "CREATE TABLE defective (
			defective_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			defective_amount VARCHAR(50) NOT NULL,
			defective_total VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "product defective table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END

	//Create table manufacture//
	try{
	$sql = "CREATE TABLE manufacture (
			manufac_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			manufac_date date NOT NULL,
			manufac_ordered VARCHAR(50) NOT NULL,
			manufac_userow VARCHAR(50) NOT NULL,
			manufac_lotnum VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "manufacture table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END

	//Create table payroll staff//
	try{
	$sql = "CREATE TABLE payrollstaff (
			salary_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			salary_paydate date NOT NULL,
			salary_payroll INT(50) NOT NULL,
			salary_status VARCHAR(50) NOT NULL,
			salary_ovtWdr INT(50) NOT NULL,
			salary_receiveAm INT(50) NOT NULL,
			salary_total INT(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "payroll staff table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END

	//Create table account//
	try{
	$sql = "CREATE TABLE account (
			account_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			account_date date NOT NULL,
			account_year VARCHAR(50) NOT NULL,
			account_desc VARCHAR(50) NOT NULL,
			account_itemtype VARCHAR(50) NOT NULL,
			account_total INT(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "Account table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END//
	//Create table maintenance machine//
	try{
	$sql = "CREATE TABLE maintenance (
			maintn_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			maintn_date date NOT NULL,
			maintn_desc VARCHAR(50) NOT NULL,
			maintn_name VARCHAR(50) NOT NULL,
			maintn_phone VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "Maintenance table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END//
	// sql to create table product type
	try{
	$sql = "CREATE TABLE producttype (
			producttype_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			producttype_name VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "product type table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//End sql to create table producttype
	// sql to create table work
	try{
	$sql = "CREATE TABLE work (
			work_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			work_date date NOT NULL,
			work_dayoff VARCHAR(50) NOT NULL,
			work_time VARCHAR(50) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "work table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	//END//
	/////Description sell////////////////////////
	try{
	$sql = "CREATE TABLE desc_sell (
			descsell_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			product_fid INT(11) NOT NULL,
			sell_fid INT(11) NOT NULL )";

			// use exec() because no results are returned
			$db->exec($sql);
			echo "<br>";
			echo "Description sell table created successfully";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e-> getMessage();
	}
	///////////////END//////////////////////////
?>
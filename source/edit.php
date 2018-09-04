
<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
?>
<?php
require_once("../database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;

if(isset($_POST['update']))
{

	$cus_id = $_POST['cus_id'];
	$cus_name = $_POST['cus_name'];
	$cus_surname = $_POST['cus_surname'];
	$gen_radio = $_POST['gen_radio'];
	$cus_mail = $_POST['cus_mail'];
	$cus_phone = $_POST['cus_phone'];
	$cus_add = $_POST['cus_add'];
	
	echo $cus_id;
	echo $cus_name;
	echo $cus_surname;
	echo $gen_radio;
	echo $cus_mail;
	echo $cus_phone;
	echo $cus_add;

	/*$sql = "UPDATE customer SET cus_name=:cus_name, cus_surname=:cus_surname, gen_radio =:gen_radio, cus_mail =:cus_mail, cus_phone=:cus_phone, cus_add =:cus_add WHERE cus_id = :cus_id";
*/
	//$sql = 'UPDATE customer SET cus_id=:cus_id, cus_name=:cus_name WHERE cus_id=:cus_id';
$sql = "UPDATE customer SET cus_name='$cus_name', cus_surname='$cus_surname', cus_mail='$cus_mail', cus_phone='$cus_phone', cus_add='$cus_add' WHERE cus_id='$cus_id'";

	$stmt = $db->prepare($sql);            ////3
	$stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
	$stmt->bindParam(':cus_name', $cus_name, PDO::PARAM_STR);
	$stmt->bindParam(':cus_surname', $cus_surname, PDO::PARAM_STR);
	$stmt->bindParam(':gen_radio', $gen_radio, PDO::PARAM_STR);
	$stmt->bindParam(':cus_mail', $cus_mail, PDO::PARAM_STR);
	$stmt->bindParam(':cus_phone', $cus_phone, PDO::PARAM_STR);
	$stmt->bindParam(':cus_add', $cus_add, PDO::PARAM_STR);
	$stmt->execute();
	//$db->execute($sql);  ///stmt = statement        /////4

	$result = $stmt->execute(array(':cus_id'=>$cus_id, 
		':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
		':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
		':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add)); //5

	if($result)
	{
	   echo 'Success, data saved. Look in your database.';
	}
	//else{
	//	echo 'Error, data not saved. There must be a problem with the code or the database credentials.';
	//}
}
?>
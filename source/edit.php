
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
if(isset($_GET['cus_id']))
{
//getting id of the data from url
$cus_id = $_GET['cus_id'];

//deleting the row from table
$sql = "DELETE FROM customer WHERE cus_id='$cus_id'";
$query = $db->prepare($sql);
$query->execute(array(':cus_id' => $cus_id));
	if ($query) {
		
		echo "<script language='javascript' type='text/javascript'>alert('Successfully Deleted!')</script>";

		echo "<meta http-equiv='refresh' content='2; url = index.php?page=customer'>" ;

		//echo "<script language='javascript' type='text/javascript'>window.open('Project/index.php?page=customer','_self')</script>";
	}
}
	//End updated customer//

	//update raw material//
if(isset($_POST['rawupdate']))
{

	$matr_id = $_POST['matr_id'];
	$matr_name = $_POST['matr_name'];
	$matr_impdate = $_POST['matr_impdate'];
	$matr_quantity = $_POST['matr_quantity'];
	$matr_price = $_POST['matr_price'];

$sql = "UPDATE rawmaterial SET matr_name='$matr_name', matr_impdate='$matr_impdate', matr_quantity='$matr_quantity', matr_price='$matr_price' WHERE matr_id='$matr_id'";

	$stmt = $db->prepare($sql);            ////3
	$stmt->bindParam(':matr_id', $matr_id, PDO::PARAM_INT);
	$stmt->bindParam(':matr_name', $matr_name, PDO::PARAM_STR);
	$stmt->bindParam(':matr_impdate', $matr_impdate, PDO::PARAM_STR);
	$stmt->bindParam(':matr_quantity', $matr_quantity, PDO::PARAM_STR);
	$stmt->bindParam(':matr_price', $matr_price, PDO::PARAM_STR);
	$stmt->execute();
	//$db->execute($sql);  ///stmt = statement        /////4

	$result = $stmt->execute(array(':matr_id'=>$matr_id, 
		':matr_name'=>$matr_name, ':matr_impdate'=>$matr_impdate, 
		':matr_quantity'=>$matr_quantity, ':matr_price'=>$matr_price)); //5

	if($result)
	{
	   echo 'Success, data saved. Look in your database.';
	}
	//else{
	//	echo 'Error, data not saved. There must be a problem with the code or the database credentials.';
	//}
}
//End updated raw material

//getting id of the data from url
/*$cus_id = $_GET['cus_id'];

//deleting the row from table
$sql = "DELETE FROM customer WHERE cus_id='$cus_id'";
$query = $db->prepare($sql);
$query->execute(array(':cus_id' => $cus_id));
	if ($query) {
		
		echo "<script language='javascript' type='text/javascript'>alert('Successfully Deleted!')</script>";

		echo "<meta http-equiv='refresh' content='2; url = index.php?page=customer'>" ;

		//echo "<script language='javascript' type='text/javascript'>window.open('Project/index.php?page=customer','_self')</script>";
	}
	*/

?>
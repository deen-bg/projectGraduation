<?php
//session_start();
require_once("../database/Db.php");
$objDb = new Db();
$db = $objDb->database;


$sql = "INSERT INTO customer (cus_id, cus_name, cus_surname, cus_gender, cus_mail, cus_phone, cus_add) 
		VALUES (:cus_id, :cus_name, :cus_surname, :gen_radio, :cus_mail, :cus_phone, :cus_add)"; //1


$form = $_POST;                         ///2
$cus_id = $form[ 'cus_id' ];
$cus_name = $form[ 'cus_name' ];
$cus_surname = $form[ 'cus_surname' ];
$gen_radio = $form[ 'gen_radio' ];
$cus_mail = $form[ 'cus_mail' ];
$cus_phone = $form[ 'cus_phone' ];
$cus_add = $form[ 'cus_add' ];

$stmt = $db->prepare($sql);            ////3
$stmt->bindParam(":cus_id", $cus_id, PDO::PARAM_INT);
$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
$stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
$stmt->bindParam(":gen_radio", $gen_radio, PDO::PARAM_STR);
$stmt->bindParam(":cus_mail", $cus_mail, PDO::PARAM_STR);
$stmt->bindParam(":cus_phone", $cus_phone, PDO::PARAM_STR);
$stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);



$stmt->execute();  ///stmt = statement        /////4

$result = $stmt->execute(array(':cus_id'=>$cus_id, 
	':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
	':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
	':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add)); //5



if($result)
{
   // echo "insert data successfully!";
    // header('Location: ../index.php');
}
else{
	//echo "insert data successfully!";
	//echo "not found insert";
	//header('Location: ../source/cus_list.php');
	//header('Location: ../index.php');
}

?>
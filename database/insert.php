<?php
//session_start();
require_once("../database/Db.php");
$objDb = new Db();
$db = $objDb->database;


	if (isset($_POST['submit']))
	{

		//get value from form
		$form = $_POST;                         ///2
		$cus_id = $form[ 'cus_id' ];
		$cus_name = $form[ 'cus_name' ];
		$cus_surname = $form[ 'cus_surname' ];
		$gen_radio = $form[ 'gen_radio' ];
		$cus_mail = $form[ 'cus_mail' ];
		$cus_phone = $form[ 'cus_phone' ];
		$cus_add = $form[ 'cus_add' ];

		/*if (empty($cus_name) || empty($cus_surname) || empty($gen_radio) || empty($cus_mail) || empty($cus_phone) || empty($cus_add)) 
		{

			echo "please enter the fullfeild!";
		}*/
				///check duplicate name //
		$sql = "SELECT cus_name AND cus_surname FROM customer WHERE cus_name = :cus_name AND cus_name = :cus_name";

	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
			$stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $cus_name มีอยู่แล้ว.')</script>";
	        return false;

	    }
		else
		{

			//insert data to cutmer table//
			$sql = "INSERT INTO customer (cus_id, cus_name, cus_surname, cus_gender, cus_mail, cus_phone, cus_add) 
					VALUES (:cus_id, :cus_name, :cus_surname, :gen_radio, :cus_mail, :cus_phone, :cus_add)"; //1

			//bind value from form to php value
					//prepare value//
			$stmt = $db->prepare($sql);            ////3
			/*$stmt->bindParam(":cus_id", $cus_id, PDO::PARAM_INT);
			$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
			$stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
			$stmt->bindParam(":gen_radio", $gen_radio, PDO::PARAM_STR);
			$stmt->bindParam(":cus_mail", $cus_mail, PDO::PARAM_STR);
			$stmt->bindParam(":cus_phone", $cus_phone, PDO::PARAM_STR);
			$stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);*/

			//$stmt->execute();  ///stmt = statement        /////4

			$result = $stmt->execute(array(':cus_id'=>$cus_id, 
				':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
				':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
				':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add)); //5

			if($result)
			{
				echo "<script>alert('Customer Data added successfully.')</script>";
				echo "<meta http-equiv='refresh' content='2; url = index.php?page=customer'>" ;
			}
			else
			{
				echo "not found insert";
			}
		}
	}
	//END insert customer//

	//insert material//
	if (isset($_POST['submitmatr']))
	{

			//get value from form
			$form = $_POST;                         ///2
			$matr_id = $form[ 'matr_id' ];
			$matr_name = $form[ 'matr_name' ];
			$matr_impdate = $form[ 'matr_impdate' ];
			$matr_quantity = $form[ 'matr_quantity' ];
			$matr_price = $form[ 'matr_price' ];

			if (empty($matr_name) || empty($matr_impdate) || empty($matr_quantity) || empty($matr_price))
			{

				echo "please enter the full feild!";
			}
					///check duplicate name //
			$sql = "SELECT matr_name FROM rawmaterial WHERE matr_name = :matr_name";

		    $stmt = $db->prepare($sql);
				$stmt->bindParam(":matr_name", $matr_name, PDO::PARAM_STR);
		    $stmt->execute();
		    if ($stmt->rowCount() > 0) {
		        echo "<script>alert('the already exite!.')</script>";
		        return false;

		    }
			else
			{

				//insert data to cutmer table//
				$sql = "INSERT INTO rawmaterial (matr_id, matr_name, matr_impdate, matr_quantity, matr_price) 
						VALUES (:matr_id, :matr_name, :matr_impdate, :matr_quantity, :matr_price)"; //1

				//bind value from form to php value
						//prepare value
				$stmt = $db->prepare($sql);
				/*            ////3
				$stmt->bindParam(":matr_id", $matr_id, PDO::PARAM_INT);
				$stmt->bindParam(":matr_name", $matr_name, PDO::PARAM_STR);
				$stmt->bindParam(":matr_impdate", $matr_impdate, PDO::PARAM_STR);
				$stmt->bindParam(":matr_quantity", $matr_quantity, PDO::PARAM_STR);
				$stmt->bindParam(":matr_price", $matr_price, PDO::PARAM_STR);
		*/
				//$stmt->execute();  ///stmt = statement        /////4

				$result = $stmt->execute(array(':matr_id'=>$matr_id, ':matr_name'=>$matr_name, ':matr_impdate'=>$matr_impdate, 
				':matr_quantity'=>$matr_quantity, ':matr_price'=>$matr_price)); //5

				if($result)
				{
					echo "<script>alert('Raw matrial Data added successfully.')</script>";
					echo "<meta http-equiv='refresh' content='2; url = index.php?page=customer'>" ;
				}
				else
				{
					echo "not found insert raw material";
				}
			}
	}
		//END insert customer//
?>
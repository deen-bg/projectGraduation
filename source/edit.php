
<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
?>
<?php
require_once("../database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;

////////////////////////////////////////update customer/////////////////////////
if(isset($_POST['update']))
{

	$cus_id = $_POST['cus_id'];
	$cus_name = $_POST['cus_name'];
	$cus_surname = $_POST['cus_surname'];
	$gen_radio = $_POST['gen_radio'];
	$cus_mail = $_POST['cus_mail'];
	$cus_phone = $_POST['cus_phone'];
	$cus_add = $_POST['cus_add'];

							//column name=variable//
	$sql = "UPDATE customer SET cus_name='$cus_name', cus_surname='$cus_surname', cus_gender='$gen_radio', cus_mail='$cus_mail', cus_phone='$cus_phone', cus_add='$cus_add' WHERE cus_id='$cus_id'";

	$stmt = $db->prepare($sql);            ////3
	$result = $stmt->execute(array(':cus_id'=>$cus_id, 
		':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
		':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
		':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$cus_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";

		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=customer'>" ; //redirect/
	}
	else
	{
		echo 'Error, data not update.';
	}
}
///END//

////////////////////////////////////////Delete customer as row///////////////////////////////////
if(isset($_GET['cus_id']))
{
	//getting id of the data from url
	$cus_id = $_GET['cus_id'];

	//deleting the row from table customer
	$sql = "DELETE FROM customer WHERE cus_id='$cus_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':cus_id' => $cus_id));
	if ($query)
	{
		echo "<script language='javascript' type='text/javascript'>alert('Successfully Deleted!')</script>";
		echo "<meta http-equiv='refresh' content='2; url = ../index.php?page=customer'>" ;
	}
}
//End//

//////////////////////////////////update raw material////////////////////////////////
if(isset($_POST['rawupdate']))
{
	$matr_id = $_POST['matr_id'];
	$matr_name = $_POST['matr_name'];
	$matr_impdate = $_POST['matr_impdate'];
	$matr_quantity = $_POST['matr_quantity'];
	$matr_price = $_POST['matr_price'];

	$sql = "UPDATE rawmaterial SET matr_name='$matr_name', matr_impdate='$matr_impdate', matr_quantity='$matr_quantity', matr_price='$matr_price' WHERE matr_id='$matr_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':matr_id'=>$matr_id, 
		':matr_name'=>$matr_name, ':matr_impdate'=>$matr_impdate, 
		':matr_quantity'=>$matr_quantity, ':matr_price'=>$matr_price));

	if($result)
	{
		echo "<script language='javascript' type='text/javascript'>alert('$matr_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=material'>";  //redirect/
	}
	else
	{
		echo 'Error, data not saved.';
	}
}
//End updated raw material

/////////////////////////////////////////////Delete material//
if(isset($_GET['matr_id']))
{
	//getting id of the data from url
	$matr_id = $_GET['matr_id'];

	//deleting the row from table rawmaterial
	$sql = "DELETE FROM rawmaterial WHERE matr_id='$matr_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':matr_id' => $matr_id));
	if ($query)
	{
		echo "<script language='javascript' type='text/javascript'>alert('rawmaterial Successfully Deleted!')</script>";
		echo "<meta http-equiv='refresh' content='2; url = ../index.php?page=customer'>" ;  //redirect//
	}
}
//End deleted raw material//

///////////////////////////////////////edit inventory row//
if(isset($_POST['inventupdate']))
{

	$invent_id = $_POST['invent_id'];
	$inven_date = $_POST['inven_date'];
	$product_amount = $_POST['product_amount'];
	$product_price = $_POST['product_price'];
	$invent_status = $_POST['invent_status'];

					//set column name = variable//
	$sql = "UPDATE inventory SET invent_date='$inven_date', invent_amount='$product_amount', invent_price='$product_price', invent_status='$invent_status' WHERE invent_id='$invent_id'";

	$stmt = $db->prepare($sql);
		//excecute array variables//
	$result = $stmt->execute(array(':invent_date'=>$inven_date, ':invent_amount'=> $product_amount,
	':invent_price'=>$product_price, ':invent_status'=>$invent_status));

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$invent_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";

		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=inventory'>";  //redirect//
	}
	else
	{
		echo 'Error, data not saved.';
	}
}
//End updated inventory

///////////////////////////////Delete inventory row////////////////////////////////////
if(isset($_GET['invent_id']))
{
	//getting id of the data from url
	$invent_id = $_GET['invent_id'];

	//deleting the row from table inventory
	$sql = "DELETE FROM inventory WHERE invent_id='$invent_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':invent_id' => $invent_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$invent_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=inventory'>"; //redirect//;
		}
}
//End deleted raw material//
//////////////////////////////////////////////Edit product///////////////////////////////
if(isset($_POST['productupdate']))
{
	$product_id = $_POST['product_id'];
	$product_name = $_POST['product_name'];
	$product_pricepd = $_POST['product_pricepd'];
	$product_amountpd = $_POST['product_amountpd'];
	$product_status = $_POST['product_status'];

		//set column name = variable//
	$sql = "UPDATE product SET product_name='$product_name', product_price='$product_pricepd', product_amount='$product_amountpd', product_status='$product_status' WHERE product_id='$product_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':product_name'=>$product_name, ':product_price'=>$product_pricepd, ':product_amount'=>$product_amountpd, ':product_status'=>$product_status));

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$product_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=product'>"; //redirect//
	}
	else
	{
		echo 'Error, data not saved.';
	}
}
//END
////////////////////////////////////Delete product row///////////////////////////////////////////////
if(isset($_GET['product_id']))
{
	//getting id of the data from url
	$product_id = $_GET['product_id'];
	//deleting the row from table product
	$sql = "DELETE FROM product WHERE product_id='$product_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':product_id' => $product_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$product_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=product'>" ; //redirect//
		}
}
//End deleted raw material//

////////////////////////////////////////Edite staff row////////////////////////
if(isset($_POST['staffupdate']))
{

	$staff_id = $_POST['staff_id'];
	$staff_name = $_POST['staff_name'];
	$staff_surname = $_POST['staff_surname'];
	$staff_passportid = $_POST['staff_passportid'];
	$staff_add = $_POST['staff_add'];
	$staff_stwd = $_POST['staff_stwd'];
	$staff_phone = $_POST['staff_phone'];

	$sql = "UPDATE staff SET staff_name='$staff_name', staff_surname='$staff_surname', 
	staff_passportid='$staff_passportid', staff_add='$staff_add', staff_stwd='$staff_stwd',
	staff_phone='$staff_phone' WHERE staff_id='$staff_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':staff_id'=>$staff_id, 
		':staff_name'=>$staff_name, ':staff_surname'=>$staff_surname, 
		':staff_passportid'=>$staff_passportid, ':staff_add'=>$staff_add,
		':staff_stwd'=>$staff_stwd, ':staff_phone'=>$staff_phone)); //5
	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$staff_id Successfully updated!')</script>";
		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=staff'>"; //redirect//
	}
	else
	{
		echo 'Error, data not saved.';
	}
}
//END//

	//////////////////////////////////////Delete staff row////////////////////////////////////
	if(isset($_GET['staff_id']))
	{
	//getting id of the data from url
	$staff_id = $_GET['staff_id'];
	//deleting the row from table inventory
	$sql = "DELETE FROM staff WHERE staff_id='$staff_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':staff_id' => $staff_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$staff_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=staff'>";  //redirect//
		}
}
//END

////////////////////////////////////////Edit selling row////////////////////////////////////
if(isset($_POST['sellupdate']))
{
	$sell_id = $_POST['sell_id'];
	$sell_date = $_POST['sell_date'];
	$sell_price = $_POST['sell_price'];
	$sell_amount = $_POST['sell_amount'];
	$sell_total = $_POST['sell_total'];
	$sell_status = $_POST['sell_status'];

	$sql = "UPDATE sell SET sell_date='$sell_date', sell_price='$sell_price',
	sell_amount='$sell_amount', sell_total='$sell_total', sell_status='$sell_status' 
	WHERE sell_id='$sell_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':sell_date'=>$sell_date, 
		':sell_price'=>$sell_price, ':sell_amount'=>$sell_amount, 
		':sell_total'=>$sell_total, ':sell_status'=>$sell_status));

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$sell_id Successfully updated!')</script>";
		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=sell'>"; //redirect//
	}
	else
	{
		echo 'Error, data not update.';
	}
}
//END

////////////////////////////////////Delete selling row//////////////////////////////////
if(isset($_GET['sell_id']))
{
	//getting id of the data from url
	$sell_id = $_GET['sell_id'];
	//deleting the row from table inventory
	$sql = "DELETE FROM sell WHERE sell_id='$sell_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':sell_id' => $sell_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$sell_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=sell'>" ; //redirect//
		}
}
//END//

///////////////////////////////////////Edit delivery row//////////////////////////////////////
if(isset($_POST['deliverupdate']))
{
	$deliver_id = $_POST['deliver_id'];			//get value from form//
	$deliver_date = $_POST['deliver_date'];
	$deliver_amount = $_POST['deliver_amount'];
	$deliver_by = $_POST['deliver_by'];

	$sql = "UPDATE product SET product_name='$product_name', product_price='$product_pricepd', 
	product_amount='$product_amountpd', product_status='$product_status' WHERE product_id='$product_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':product_name'=>$product_name, ':product_price'=>$product_pricepd, 
		':product_amount'=>$product_amountpd, ':product_status'=>$product_status));

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$deliver_id Successfully updated!')</script>";
		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=delivery'>";	//redirect//
	}
	else{
		echo 'Error, data not update.';
	}
}
//END//
///////////////////////////////////////Delete delivery row//////////////////////////////////////////
if(isset($_GET['deliver_id']))
{
	//getting id of the data from url
	$deliver_id = $_GET['deliver_id'];
	//deleting the row from table inventory
	$sql = "DELETE FROM delivery WHERE deliver_id='$deliver_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':deliver_id' => $deliver_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$deliver_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=delivery'>";	//redirect//
		}
}
//END//
////////////////////////////////////////////Edit defective product////////////////////////////
if(isset($_POST['defectiveupdate']))
{
	$defective_id = $_POST['defective_id'];
	$defective_amount = $_POST['defective_amount'];
	$defective_total = $_POST['defective_total'];

	$sql = "UPDATE defective SET defective_amount='$defective_amount', defective_total='$defective_total' 
	WHERE defective_id='$defective_id'";

	$stmt = $db->prepare($sql);            ////3
	$result = $stmt->execute(array(':defective_amount'=>$defective_amount, ':defective_total'=>$defective_total)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$defective_id Successfully updated!')</script>";
		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=defective'>" ;
	}
	else
	{
		echo 'Error, data not update.';
	}
}
//END
///////////////////////////////////////Delete product defective row////////////////////////////////////////
if(isset($_GET['defective_id']))
{
	//getting id of the data from url
	$defective_id = $_GET['defective_id'];

	//deleting the row from table inventory
	$sql = "DELETE FROM defective WHERE defective_id='$defective_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':defective_id' => $defective_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$defective_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=defective'>" ;
		}
}
//END///

//////////////////////////////////////////////Edit manufacture row////////////
if(isset($_POST['manufacupdate']))
{
	$manufac_id = $_POST['manufac_id'];
	$manufac_date = $_POST['manufac_date'];
	$manufac_ordered = $_POST['manufac_ordered'];
	$manufac_userow = $_POST['manufac_userow'];
	$manufac_lotnum = $_POST['manufac_lotnum'];

$sql = "UPDATE manufacture SET manufac_date='$manufac_date', manufac_ordered='$manufac_ordered', manufac_userow='$manufac_userow', manufac_lotnum='$manufac_lotnum' WHERE manufac_id='$manufac_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':manufac_id'=>$manufac_id, 
		':manufac_date'=>$manufac_date, ':manufac_ordered'=>$manufac_ordered, 
		':manufac_userow'=>$manufac_userow, ':manufac_lotnum'=>$manufac_lotnum)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$manufac_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
	   echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=manufacture'>" ;
	}
	else
	{
		echo 'Error, data not update.';
	}
}
//END
////////////////////////////////////////Delete manufac row/////////////////////////
if(isset($_GET['manufac_id']))
{
	//getting id of the data from url
	$manufac_id = $_GET['manufac_id'];

	//deleting the row from table inventory
	$sql = "DELETE FROM manufacture WHERE manufac_id='$manufac_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':manufac_id' => $manufac_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$manufac_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=manufacture'>" ;
		}
}
//END
////////////////////////////////////Edit staff salary payroll//////////////////////////////
if(isset($_POST['selaryupdate']))
{
	$salary_id = $_POST['salary_id'];
	$salary_paydate = $_POST['salary_paydate'];
	$salary_payroll = $_POST['salary_payroll'];
	$salary_status = $_POST['salary_status'];
	$salary_ovtWdr = $_POST['salary_ovtWdr'];
	$salary_receiveAm = $_POST['salary_receiveAm'];
	$salary_total = $_POST['salary_total'];

$sql = "UPDATE payrollstaff SET salary_paydate='$salary_paydate', salary_payroll='$salary_payroll',
 salary_status='$salary_status', salary_ovtWdr='$salary_ovtWdr', salary_receiveAm='$salary_receiveAm', 
 salary_total='$salary_total'
  WHERE salary_id='$salary_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':salary_id'=>$salary_id, 
		':salary_paydate'=>$salary_paydate, ':salary_payroll'=>$salary_payroll, 
		':salary_status'=>$salary_status, ':salary_ovtWdr'=>$salary_ovtWdr, ':salary_receiveAmr'=>$salary_receiveAm, ':salary_total'=>$salary_total)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$salary_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
	   echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=salary'>" ;
	}
	else
	{
		echo 'Error, data not update.';
	}
}
//END//
/////////////////////////////////Delete row staff salary payroll//////////////////////////
if(isset($_GET['salary_id']))
{
	//getting id of the data from url
	$salary_id = $_GET['salary_id'];

	//deleting the row from table inventory
	$sql = "DELETE FROM payrollstaff WHERE salary_id='$salary_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':salary_id' => $salary_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$salary_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=salary'>" ;
		}
}
//END//
//////////////////////////////////////////////Edit account////////////////////////////////////
if(isset($_POST['accountupdate']))
{
	$account_id = $_POST['account_id'];
	$account_date = $_POST['account_date'];
	$account_year = $_POST['account_year'];
	$account_desc = $_POST['account_desc'];
	$account_itemtype = $_POST['account_itemtype'];
	$account_total = $_POST['account_total'];

$sql = "UPDATE account SET account_date='$account_date', account_year='$account_year',
 account_desc='$account_desc', account_itemtype='$account_itemtype', account_total='$account_total'
  WHERE account_id='$account_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':account_id'=>$account_id, 
		':account_date'=>$account_date, ':account_year'=>$account_year, 
		':account_desc'=>$account_desc, ':account_itemtype'=>$account_itemtype, ':account_total'=>$account_total)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$account_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
	  // echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=salary'>" ;
	}
	else
	{
		echo 'Error, data not update.';
	}
}
//END//
//Delete account row//
if(isset($_GET['account_id']))
{
	//getting id of the data from url
	$account_id = $_GET['account_id'];

	//deleting the row from table inventory
	$sql = "DELETE FROM account WHERE account_id='$account_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':account_id' => $account_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$account_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='0.5; url = ../index.php?page=finance'>" ;
		}
}
//END//

//Edit machine row//
if(isset($_POST['machineupdate']))
{

	$maintn_id = $_POST['maintn_id'];
	$maintn_date = $_POST['maintn_date'];
	$maintn_desc = $_POST['maintn_desc'];
	$maintn_name = $_POST['maintn_name'];
	$maintn_phone = $_POST['maintn_phone'];

	echo $maintn_id;
	echo $maintn_date;
	echo $maintn_desc;
	echo $maintn_name;
	echo $maintn_phone;
							//column name=variable//
	$sql = "UPDATE maintenance SET maintn_date='$maintn_date', maintn_desc='$maintn_desc', maintn_name='$maintn_name', maintn_phone='$maintn_phone' WHERE maintn_id='$maintn_id'";

	$stmt = $db->prepare($sql);            ////3
	$result = $stmt->execute(array(':maintn_id'=>$maintn_id, 
		':maintn_date'=>$maintn_date, ':maintn_desc'=>$maintn_desc, 
		':maintn_name'=>$maintn_name, ':maintn_phone'=>$maintn_phone)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$maintn_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";

		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=repairmachine'>" ;
	}
	else
	{
		echo 'Error, data not update.';
	}
}
//END//
//Delete machine maintenance//
if(isset($_GET['maintn_id']))
{
	//getting id of the data from url
	$maintn_id = $_GET['maintn_id'];

	//deleting the row from table inventory
	$sql = "DELETE FROM maintenance WHERE maintn_id='$maintn_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':maintn_id' => $maintn_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$maintn_id Successfully Deleted!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=repairmachine'>" ;
		}
}
//END//
ob_end_flush();
?>
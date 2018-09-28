<?php
//session_start();
require_once("../database/Db.php");
$objDb = new Db();
$db = $objDb->database;

//insert data to customer table
if (isset($_POST['submitcustomer']))
{
	//get value from form
	$form = $_POST;
	$cus_id = $form[ 'cus_id' ];
	$cus_name = $form[ 'cus_name' ];
	$cus_surname = $form[ 'cus_surname' ];
	$gen_radio = $form[ 'gen_radio' ];
	$cus_mail = $form[ 'cus_mail' ];
	$cus_phone = $form[ 'cus_phone' ];
	$cus_add = $form[ 'cus_add' ];

	if (empty($cus_name) || empty($cus_surname) || empty($gen_radio) || empty($cus_mail) || empty($cus_phone) || empty($cus_add))
	{
		echo "please enter the fullfeild!";
	}
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

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':cus_id'=>$cus_id, ':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
				':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail, ':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add));

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

//insert data to material table//
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
		if ($stmt->rowCount() > 0)
		{
			echo "<script>alert('the already exite!.')</script>";
			return false;
		}
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO rawmaterial (matr_id, matr_name, matr_impdate, matr_quantity, matr_price) 
				VALUES (:matr_id, :matr_name, :matr_impdate, :matr_quantity, :matr_price)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

		$result = $stmt->execute(array(':matr_id'=>$matr_id, ':matr_name'=>$matr_name, ':matr_impdate'=>$matr_impdate, 
				':matr_quantity'=>$matr_quantity, ':matr_price'=>$matr_price)); //5

		if($result)
		{
			echo "<script>alert('Raw matrial Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=material'>" ;
		}
		else
		{
			echo "not found insert raw material";
		}
	}
}
//END insert customer//

//insert data to inventory table//
if (isset($_POST['submitinventr']))
{
	//get value from form
	$form = $_POST;
	$invent_id = $form[ 'invent_id' ];
	$inven_date = $form[ 'inven_date' ];
	$product_amount = $form[ 'product_amount' ];
	$product_price = $form[ 'product_price' ];
	$invent_status = $form[ 'invent_status' ];
		//check availability//
	if (empty($inven_date) || empty($product_amount) || empty($product_price) || empty($invent_status))
	{
		echo "please enter the full feild!";
	}
					///check duplicate name //
		$sql = "SELECT * FROM inventory WHERE invent_id = :invent_id";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(":invent_id", $invent_id, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
		    echo "<script>alert('the already exite!.')</script>";
		    return false;
		}
	else
	{
			//Column name=invent_id, invent_date, invent_amount, invent_price, invent_status
		$sql = "INSERT INTO inventory (invent_id, invent_date, invent_amount, invent_price, invent_status) 
						VALUES (:invent_id, :inven_date, :product_amount, :product_price, :invent_status)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

			//excecute array value//
		$result = $stmt->execute(array(':invent_id'=>$invent_id, ':inven_date'=>$inven_date,
				 ':product_amount'=>$product_amount, ':product_price'=>$product_price, ':invent_status'=>$invent_status)); //5
					//check result//
		if($result)
		{
			echo "<script>alert('Inventory Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=inventory'>" ;
		}
		else
		{
			echo "not found insert inventory";
		}
	}
}
//END insert inventory//

//insert data to product table//
if (isset($_POST['submitproduct']))
{
	//get value from form
	$form = $_POST;
	$product_id = $form[ 'product_id' ];
	$product_name = $form[ 'product_name' ];
	$product_pricepd = $form[ 'product_pricepd' ];
	$product_amountpd = $form[ 'product_amountpd' ];
	$product_status = $form[ 'product_status' ];

	if (empty($product_name) || empty($product_pricepd) || empty($product_amountpd) || empty($product_status))
	{

		echo "please enter the full feild!";
	}
					///check duplicate name //
		$sql = "SELECT * FROM product WHERE product_id = :product_id";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(":product_id", $product_id, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
		    echo "<script>alert('the already exite!.')</script>";
		    return false;
		}
	else
	{
		$sql = "INSERT INTO product (product_id, product_name, product_price, product_status, product_amount) 
		VALUES (:product_id, :product_name, :product_pricepd, :product_amountpd, :product_status)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

			//excecute array value//
		$result = $stmt->execute(array(':product_id'=>$product_id, ':product_name'=>$product_name,
				 ':product_pricepd'=>$product_pricepd, ':product_status'=>$product_status, ':product_amountpd'=>$product_amountpd)); //5
					//check result//
		if($result)
		{
			echo "<script>alert('Product Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=product'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END insert product//

//insert staff//
if (isset($_POST['staffsubmit']))
{
	//get value from form
	$form = $_POST;
	$staff_id = $form[ 'staff_id' ];
	$staff_name = $form[ 'staff_name' ];
	$staff_surname = $form[ 'staff_surname' ];
	$staff_passportid = $form[ 'staff_passportid' ];
	$staff_add = $form[ 'staff_add' ];
	$staff_stwd = $form[ 'staff_stwd' ];
	$staff_phone = $form[ 'staff_phone' ];

	if (empty($staff_name) || empty($staff_surname) || empty($staff_passportid) || empty($staff_add) || empty($staff_stwd) || empty($staff_phone))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT staff_name AND staff_surname FROM staff WHERE staff_name = :staff_name AND staff_surname = :staff_surname";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":staff_name", $staff_name, PDO::PARAM_STR);
			$stmt->bindParam(":staff_surname", $staff_surname, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $staff_name มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO staff (staff_id, staff_name, staff_surname, staff_passportid, staff_add, staff_stwd, staff_phone) 
				VALUES (:staff_id, :staff_name, :staff_surname, :staff_passportid, :staff_add, :staff_stwd, :staff_phone)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);

		$result = $stmt->execute(array(':staff_id'=>$staff_id, ':staff_name'=>$staff_name, ':staff_surname'=>$staff_surname, 
				':staff_passportid'=>$staff_passportid, ':staff_add'=>$staff_add,
				 ':staff_stwd'=>$staff_stwd, ':staff_phone'=>$staff_phone));
		if($result)
		{
			echo "<script>alert('Staff Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=customer'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//

//insert into sell table
if (isset($_POST['sellsubmit']))
{
	//get value from form
	$form = $_POST;
	$sell_id = $form[ 'sell_id' ];
	$sell_date = $form[ 'sell_date' ];
	$sell_price = $form[ 'sell_price' ];
	$sell_amount = $form[ 'sell_amount' ];
	$sell_total = $form[ 'sell_total' ];
	$sell_status = $form[ 'sell_status' ];

	if (empty($sell_date) || empty($sell_price) || empty($sell_amount) || empty($sell_total) || empty($sell_status))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT * FROM sell WHERE sell_id = :sell_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO sell (sell_id, sell_date, sell_price, sell_amount, sell_total, sell_status) 
				VALUES (:sell_id, :sell_date, :sell_price, :sell_amount, :sell_total, :sell_status)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':sell_id'=>$sell_id, ':sell_date'=>$sell_date, ':sell_price'=>$sell_price, 
				':sell_amount'=>$sell_amount, ':sell_total'=>$sell_total,
				 ':sell_status'=>$sell_status));

		if($result)
		{
			echo "<script>alert('Sell Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=sell'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//

//insert into delivery table
if (isset($_POST['deliversubmit']))
{
	//get value from form
	$form = $_POST;
	$deliver_id = $form[ 'deliver_id' ];
	$deliver_date = $form[ 'deliver_date' ];
	$deliver_amount = $form[ 'deliver_amount' ];
	$deliver_by = $form[ 'deliver_by' ];

	if (empty($deliver_date) || empty($deliver_amount) || empty($deliver_by))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
	/*	$sql = "SELECT * FROM sell WHERE sell_id = :sell_id";
	    $stmt = $db->prepare($sql);
		$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }*/
	else
	{
		//insert data to delivery table//
		$sql = "INSERT INTO delivery (	deliver_id, deliver_date, deliver_amount, deliver_by) 
				VALUES (:deliver_id, :deliver_date, :deliver_amount, :deliver_by)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':deliver_id'=>$deliver_id, ':deliver_date'=>$deliver_date, ':deliver_amount'=>$deliver_amount, 
				':deliver_by'=>$deliver_by));

		if($result)
		{
			echo "<script>alert('Delivery Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = ../Project/index.php?page=delivery'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END

//insert into product defective
if (isset($_POST['defectsubmit']))
{
	//get value from form
	$form = $_POST;
	$defective_id = $form[ 'defective_id' ];
	$defective_amount = $form[ 'defective_amount' ];
	$defective_total = $form[ 'defective_total' ];

	if (empty($defective_amount) || empty($defective_total))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
	/*	$sql = "SELECT * FROM sell WHERE sell_id = :sell_id";
	    $stmt = $db->prepare($sql);
		$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }*/
	else
	{
		//insert data to delivery table//
		$sql = "INSERT INTO defective (defective_id, defective_amount, defective_total) 
				VALUES (:defective_id, :defective_amount, :defective_total)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':defective_id'=>$defective_id, ':defective_amount'=>$defective_amount, ':defective_total'=>$defective_total));

		if($result)
		{
			echo "<script>alert('Defective product Data added successfully.')</script>";
			//echo "<meta http-equiv='refresh' content='2; url = ../Project/index.php?page=delivery'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//

//insert into manufacture//
if (isset($_POST['manufacsubmit']))
{
	//get value from form
	$form = $_POST;
	$manufac_id = $form[ 'manufac_id' ];
	$manufac_date = $form[ 'manufac_date' ];
	$manufac_ordered = $form[ 'manufac_ordered' ];
	$manufac_userow = $form[ 'manufac_userow' ];
	$manufac_lotnum = $form[ 'manufac_lotnum' ];

	if (empty($manufac_date) || empty($manufac_ordered) || empty($manufac_userow) || empty($manufac_lotnum))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT * FROM manufacture WHERE manufac_lotnum = :manufac_lotnum";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":manufac_lotnum", $manufac_lotnum, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO manufacture (manufac_id, manufac_date, manufac_ordered, manufac_userow, manufac_lotnum) 
				VALUES (:manufac_id, :manufac_date, :manufac_ordered, :manufac_userow, :manufac_lotnum)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':manufac_id'=>$manufac_id, ':manufac_date'=>$manufac_date, 
			':manufac_ordered'=>$manufac_ordered, ':manufac_userow'=>$manufac_userow, ':manufac_lotnum'=>$manufac_lotnum));

		if($result)
		{
			echo "<script>alert('manufacture Data added successfully.')</script>";
			//echo "<meta http-equiv='refresh' content='2; url = index.php?page=sell'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END
//insert into payroll staff//
if (isset($_POST['salarysubmit']))
{
	//get value from form
	$form = $_POST;
	$salary_id = $form[ 'salary_id' ];
	$salary_paydate = $form[ 'salary_paydate' ];
	$salary_payroll = $form[ 'salary_payroll' ];
	$salary_status = $form[ 'salary_status' ];
	$salary_ovtWdr = $form[ 'salary_ovtWdr' ];
	$salary_receiveAm = $form[ 'salary_receiveAm' ];
	$salary_total = $form[ 'salary_total' ];

	if (empty($salary_paydate) || empty($salary_payroll) || empty($salary_status) || empty($salary_ovtWdr) 
		|| empty($salary_receiveAm) || empty($salary_total))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT * FROM payrollstaff WHERE salary_id = :salary_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":salary_id", $salary_id, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO payrollstaff (salary_id, salary_paydate, salary_payroll, salary_status, salary_ovtWdr, salary_receiveAm, salary_total) 
				VALUES (:salary_id, :salary_paydate, :salary_payroll, :salary_status, :salary_ovtWdr, :salary_receiveAm, :salary_total)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':salary_id'=>$salary_id, ':salary_paydate'=>$salary_paydate, 
			':salary_payroll'=>$salary_payroll, ':salary_status'=>$salary_status, 
			':salary_ovtWdr'=>$salary_ovtWdr, ':salary_receiveAm'=>$salary_receiveAm, ':salary_total'=>$salary_total));

		if($result)
		{
			echo "<script>alert('Payroll staff Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='1; url = index.php?page=salary'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//
//Insert into account//
if (isset($_POST['submitaccount']))
{
	//get value from form
	$form = $_POST;
	$account_id = $form[ 'account_id' ];
	$account_date = $form[ 'account_date' ];
	$account_year = $form[ 'account_year' ];
	$account_desc = $form[ 'account_desc' ];
	$account_itemtype = $form[ 'account_itemtype' ];
	$account_total = $form[ 'account_total' ];

	if (empty($account_date) || empty($account_year) || empty($account_desc) || empty($account_itemtype) 
		|| empty($account_total))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT account_id FROM account WHERE account_id = :account_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":account_id", $account_id, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $account_id มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO account (account_id, account_date, account_year, account_desc, account_itemtype, account_total) 
				VALUES (:account_id, :account_date, :account_year, :account_desc, :account_itemtype, :account_total)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':account_id'=>$account_id, ':account_date'=>$account_date, ':account_year'=>$account_year, 
				':account_desc'=>$account_desc, ':account_itemtype'=>$account_itemtype, ':account_total'=>$account_total));

		if($result)
		{
			echo "<script>alert('account Data added successfully.')</script>";
			//echo "<meta http-equiv='refresh' content='2; url = index.php?page=repairmachine'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//
//Insert into maintenance machine//
if (isset($_POST['submitmaintenance']))
{
	//get value from form
	$form = $_POST;
	$maintn_id = $form[ 'maintn_id' ];
	$maintn_date = $form[ 'maintn_date' ];
	$maintn_desc = $form[ 'maintn_desc' ];
	$maintn_name = $form[ 'maintn_name' ];
	$maintn_phone = $form[ 'maintn_phone' ];

	if (empty($maintn_date) || empty($maintn_desc) || empty($maintn_name) || empty($maintn_phone))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT maintn_id FROM maintenance WHERE maintn_id = :maintn_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":maintn_id", $maintn_id, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $maintn_id มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO maintenance (maintn_id, maintn_date, maintn_desc, maintn_name, maintn_phone) 
				VALUES (:maintn_id, :maintn_date, :maintn_desc, :maintn_name, :maintn_phone)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':maintn_id'=>$maintn_id, ':maintn_date'=>$maintn_date, ':maintn_desc'=>$maintn_desc, 
				':maintn_name'=>$maintn_name, ':maintn_phone'=>$maintn_phone));

		if($result)
		{
			echo "<script>alert('Machine maintenance Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=repairmachine'>" ;
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//
//insertdata into product type//
if (isset($_POST['submitproductType']))
{

	//get value from form
	$form = $_POST;                         ///2
	$producttype_id = $form[ 'producttype_id' ];
	$producttype_name = $form[ 'producttype_name' ];

	echo $producttype_id;
	echo $producttype_name;

	if (empty($producttype_name))
	{

		echo "please enter the full feild!";
	}
		///check duplicate name //
		$sql = "SELECT * FROM producttype WHERE producttype_name = :producttype_name";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(":producttype_name", $producttype_name, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
		    echo "<script>alert('the already exite!.')</script>";
		    return false;

		}
	else
	{
			//Column name=invent_id, invent_date, invent_amount, invent_price, invent_status
		$sql = "INSERT INTO producttype (producttype_id, producttype_name) VALUES (:producttype_id, :producttype_name)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

		//excecute array value//
		$result = $stmt->execute(array(':producttype_id'=>$producttype_id, ':producttype_name'=>$producttype_name)); //5
			//check result//
		if($result)
		{
			echo "<script>alert('Product type Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=customer'>" ;
		}
		else
		{
			echo "not found insert product type";
		}
	}
}
//END insert product type//
//insert into product defective//

//END//
?>
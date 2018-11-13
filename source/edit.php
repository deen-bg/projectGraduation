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

		echo "<meta http-equiv='refresh' content='0; url = ../Project/index.php?page=customer'>" ; //redirect/
	}
	else
	{
		echo 'อัพเดทไม่สำเร็จ.';
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
		echo "<script language='javascript' type='text/javascript'>alert('ลบข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='2; url = ../index.php?page=customer'>" ;
	}
}
//End//
////////////////////////sell delete multi reccord////////////////////////////////////////////////
if(isset($_POST['datacus'])){
	$dataArr = $_POST['datacus']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM customer WHERE cus_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
/////////////////////////////////////////////////////////////////////////////////////

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
			echo "<script language='javascript' type='text/javascript'>alert('$matr_name แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../Project/index.php?page=material'>" ; //redirect/
		}
	else
	{
		 echo "<script language='javascript' type='text/javascript'>alert('$matr_name แก้ไขข้อมูลไม่สำเร็จ')</script>";

		echo "<meta http-equiv='refresh' content='0; url = ../Project/index.php?page=addnewrowMaterial'>" ; //redirect/
	}
}
//End updated raw material

///////////////////////////////////Delete material//
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
		echo "<script language='javascript' type='text/javascript'>alert('ลบข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=material'>" ;  //redirect//
	}
}
//End deleted raw material//
////////////////////////rows material delete multi rows//////////////////
if(isset($_POST['datarows'])){
	$dataArr = $_POST['datarows']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM rawmaterial WHERE matr_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
///////////////////////////////////////////////////////////////

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
			echo "<script language='javascript' type='text/javascript'>alert('$invent_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
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
	$producttype_fid = $_POST['producttype_fid'];

		//set column name = variable//
	$sql = "UPDATE product SET product_name='$product_name', product_price='$product_pricepd',
	 product_amount='$product_amountpd', product_status='$product_status', producttype_fid='$producttype_fid'
	 WHERE product_id='$product_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':product_name'=>$product_name, ':product_price'=>$product_pricepd, ':product_amount'=>$product_amountpd, ':product_status'=>$product_status, ':producttype_fid'=>$producttype_fid));
	if($result)
		{
			?> <script>alert('<?php echo $product_id ?> แก้ไขข้อมูลเรียบร้อยแล้ว!')
						window.location="../index.php?page=product";
			</script>
			<?php
		}
	else
	{
		?> <script>alert('<?php echo $product_id ?>แก้ไขข้อมูลไม่สำเร็จ')
						window.location="../index.php?page=addnewProduct";
			</script>
			<?php
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
			echo "<script language='javascript' type='text/javascript'>alert('$product_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=product'>" ; //redirect//
		}
}
//End deleted raw material//
////////////////////////products delete multi rows//////////////////
if(isset($_POST['datapd'])){
	$dataArr = $_POST['datapd']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM product WHERE product_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
///////////////////////////////////////////////////////////////
//////////////////////////Edit product Model/////////////////////////////////
if(isset($_POST['pmodelupdate']))
{
	//get value from form pmodel_img
//get value from form pmodel_img
	$form = $_POST;
	$pmodel_id = $form[ 'pmodel_id' ];
	$pmodel_name = $form[ 'pmodel_name' ];
	$pmodel_desc = $form[ 'pmodel_desc' ];

	$pmodel_img=$_FILES['pmodel_img'];
    $filename = $_FILES['pmodel_img']['name'];
    $filetemp = $_FILES['pmodel_img']['tmp_name'];
    $filesize = $_FILES['pmodel_img']['size'];
    $filebasename = basename($_FILES['pmodel_img']['name']);
    $dir="../imgUpload/";	//set upload folder path
    $finaldir=$dir.$filebasename;
	    move_uploaded_file($filetemp,$finaldir); //move upload file temperory directory to your upload folder
		//set column name = variable//
	$sql = "UPDATE productmodel SET pmodel_name='$pmodel_name', pmodel_desc='$pmodel_desc',
	 pmodel_img='$filebasename'
	 WHERE pmodel_id='$pmodel_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':pmodel_name'=>$pmodel_name, ':pmodel_desc'=>$pmodel_desc,
	 ':pmodel_img'=>$filebasename));

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$pmodel_nameเพิ่มข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=productmodel'>" ; //redirect//
	}
	else
	{
		echo 'Error, data not saved.';
	}
}
/////////////////////////END///////////////////////
/////////////////////////////////Delete pduct Model
if(isset($_GET['pmodel_id']))
{
	//getting id of the data from url
	$pmodel_id = $_GET['pmodel_id'];
	//deleting the row from table product
	$sql = "DELETE FROM productmodel WHERE pmodel_id='$pmodel_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':pmodel_id' => $pmodel_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$pmodel_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=productmodel'>" ; //redirect//
		}
}
/////////////////////////////////END///////////////////////////////////////
////////////////////////productModel delete multi rows//////////////////
if(isset($_POST['datapModel'])){
	$dataArr = $_POST['datapModel']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM productmodel WHERE pmodel_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
///////////////////////////////////////////////////////////////

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
	   echo "<script language='javascript' type='text/javascript'>alert('$staff_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=staff'>"; //redirect//
	}
	else
	{
		echo 'แก้ไขข้อมูลไม่สำเร็จ.';
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
			echo "<script language='javascript' type='text/javascript'>alert('$staff_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=staff'>";  //redirect//
		}
}
///////////////////////////////END////////////////////////////////////////////////////////////
////////////////////////staff delete multi rows//////////////////
if(isset($_POST['datastaff'])){
	$dataArr = $_POST['datastaff']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM staff WHERE staff_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
///////////////////////////////////////////////////////////////

////////////////////////////////////////Edit selling row////////////////////////////////////
if(isset($_POST['sellupdate']))
{
	$sell_id = $_POST['sell_id'];
	$sell_status = $_POST['sell_status'];

	$sql = "UPDATE sell SET sell_status='$sell_status' WHERE sell_id='$sell_id'";
	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':sell_status'=>$sell_status));
	if($result)
	{
		if ($result =='ชำระเงินแล้ว') 
		{
			$sql ="SELECT SUM(sell_total) AS value_sum FROM desc_sell WHERE sell_fid='$sell_id'";
			$stmt3 = $db->prepare($sql);   //เตรียมคำสั่ง SQL
			$stmt3->execute();
			while($row = $stmt3->fetch(PDO::FETCH_OBJ))
			{
				$sumtotal = $row->value_sum;
			}
			/*echo $sumtotal;*/
			$des ='ค่าขายของ';
			$type ='รายรับ';
			 //insert data to cutmer table//
			$sql = "INSERT INTO account (account_date, account_desc, account_itemtype, account_total) 
					VALUES (NOW(), :account_desc, :account_itemtype, :account_total)"; //1
			$stmt = $db->prepare($sql);//prepare value//
			$result = $stmt->execute(array(':account_desc'=>$des, ':account_itemtype'=>$type, 
				':account_total'=>$sumtotal));
			if ($result)
			{
				echo "<script language='javascript' type='text/javascript'>alert('รหัส.$sell_id สถานะถูกเปลี่ยนเป็น.$sell_status.เรียบร้อยแล้ว!')</script>";
				echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=sell'>";
			}
		}
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>alert('สถานะไม่ถูกเปลี่ยน! กรุณาตรวจสอบอีกครั้ง')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=sellEditform'>"; //redirect//*/
	}
}
/////////////////////////////////////END////////////////////////////////////////////////
////////////////Cancle sell row Restore products Qty for product table/////
if (isset($_GET['sell_Cancle'])) 
{
	$sell_id = $_GET['sell_Cancle'];//getting id of the data from url
	//select status column for manufac table where id
	$sql = 'SELECT sell_status FROM sell WHERE sell_id=:sell_id'; 
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':sell_id' => $sell_id]);
		while($row = $stmt->fetch(PDO::FETCH_OBJ))
		{
			if ($row->sell_status =='ยกเลิก')
			{
				echo "ok";
			}
			else
			{		//update table sell set column status = 'cancle' where id=Pk
				$sql = "UPDATE sell SET sell_status='ยกเลิก' WHERE sell_id='$sell_id'";
				$stmt2 = $db->prepare($sql);
				$result = $stmt2->execute(array(':sell_id'=>$sell_id)); //5

				//select  manufac_QtyrMtr, descmtr_fid column from desc_sell table where Fk=Pk
				$sql = "SELECT sell_amount, product_fid FROM desc_sell WHERE sell_fid='$sell_id'";
				$stmt3 = $db->prepare($sql);   //เตรียมคำสั่ง SQL
				$stmt3->execute();
				while($row = $stmt3->fetch(PDO::FETCH_OBJ))
				{		//Restere for rawmaterial table SET Qty + $row->manufac_QtyrMtr where Pk=Fk[row]
					$sql ="UPDATE product SET product_qty = product_qty + $row->sell_amount 
					WHERE product_id =$row->product_fid";
					$stmtraw = $db->prepare($sql);
					$stmtraw->execute();
				}
				echo "<script language='javascript' type='text/javascript'>
		alert('$sell_id การขายถูกยกเลิกเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=sell'>" ;
			}
		}

}
///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Delete selling row//////////////////////////////////
if(isset($_GET['sell_id']))
{
	//getting id of the data from url
	$sell_id = $_GET['sell_id'];

		//Delete 2 table are manufac & desc_manufa table//
	$sql = "DELETE sell, desc_sell FROM sell INNER JOIN desc_sell 
	WHERE sell.sell_id = desc_sell.sell_fid and sell.sell_id=:sell_id";
	$query = $db->prepare($sql);
	$query->execute(array(':sell_id' => $sell_id));
	if ($query)
	{
		echo "<script language='javascript' type='text/javascript'>
		alert('$sell_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=sell'>" ; //redirect//
	}
}
//END//
////////////////////////sell delete multi reccord////////////////////////////////////////////////
if(isset($_POST['data'])){
	$dataArr = $_POST['data'] ; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM sell WHERE sell_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
/////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////Edit delivery row//////////////////////////////////////
if(isset($_POST['deliverupdate']))
{
	$deliver_id = $_POST['deliver_id'];			//get value from form//
	$deliver_date = $_POST['deliver_date'];
	$deliver_sellid = $_POST['deliver_sellid'];
	$deliver_by = $_POST['deliver_by'];
	$deliver_stafffid = $_POST['deliver_stafffid'];
	$deliver_status = $_POST['deliver_status'];

	$sql = "UPDATE delivery SET deliver_date='$deliver_date', deliver_sellid='$deliver_sellid',
	 deliver_by='$deliver_by', deliver_stafffid='$deliver_stafffid',deliver_status='$deliver_status' 
	 WHERE deliver_id='$deliver_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':deliver_date'=>$deliver_date, ':deliver_sellid'=>$deliver_sellid, 
		':deliver_by'=>$deliver_by, ':deliver_stafffid'=>$deliver_stafffid, ':deliver_status'=>$deliver_status));


		////////////////////update table sell set deliver_status///////////////////////////////////
		$sql = "UPDATE sell SET sell_deliverStatus='จัดส่งแล้ว' WHERE sell_id='$deliver_sellid'";
		$stmt2 = $db->prepare($sql);
		$result2 = $stmt2->execute();
		/////////////////////////////////////////////END///////////////////////////////////////////

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$deliver_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=delivery'>";	//redirect//
	}
	else{
		 echo "<script language='javascript' type='text/javascript'>alert('$deliver_id แก้ไขข้อมูลไม่สำเร็จ!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../Project/index.php?page=addnewDelivery'>";	//redirect//
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
			echo "<script language='javascript' type='text/javascript'>alert('$deliver_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=delivery'>";	//redirect//
		}
}
//END//////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////productModel delete multi rows//////////////////
if(isset($_POST['datadeliver'])){
	$dataArr = $_POST['datadeliver']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM delivery WHERE deliver_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
///////////////////////////////////////////////////////////////
////////////////////////////////////////////Edit defective product////////////////////////////
if(isset($_POST['defectiveupdate']))
{
	$defective_id = $_POST['defective_id'];
	$defective_date = $_POST['defective_date'];
	$defective_amount = $_POST['defective_amount'];
	$pddefective_fid = $_POST['pddefective_fid'];

	$sql ="SELECT product_price FROM product WHERE product_id=:pddefective_fid";
	$stmt = $db->prepare($sql);
	$result = $stmt->execute([':pddefective_fid'=> $pddefective_fid]);

	$pdDefec_total = 0;
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$p_price = $row->product_price;
	}
	$pdDefec_total = $p_price * $defective_amount;

	$sql = "UPDATE defective SET defective_date='$defective_date', defective_amount='$defective_amount', defective_total='$pdDefec_total', pddefective_fid='$pddefective_fid' 
	WHERE defective_id='$defective_id'";

	$stmt = $db->prepare($sql);            ////3
	$result = $stmt->execute(array(':defective_date'=>$defective_date, ':defective_amount'=>$defective_amount, 
		':defective_total'=>$pdDefec_total, ':pddefective_fid'=>$pddefective_fid)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$defective_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=defective'>" ;
	}
	else
	{
		 echo "<script language='javascript' type='text/javascript'>alert('$defective_id แก้ไขข้อมูลไม่สำเร็จ')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=addnewDefective'>" ;
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
			echo "<script language='javascript' type='text/javascript'>alert('$defective_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=defective'>" ;
		}
}
///////////////////////////////END///////////////////////////////////////////////////////////////////
////////////////////////sell delete multi reccord////////////////////////////////////////////////
if(isset($_POST['datapdDefec'])){
	$dataArr = $_POST['datapdDefec']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM defective WHERE defective_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
////////////////////////////////////END/////////////////////////////////////////////////

//////////////////////////////////////////////Edit manufacture row////////////
if(isset($_POST['manufacupdate']))
{
	$manufac_id = $_POST['manufac_id'];
	$manufac_status = $_POST['manufac_status'];

	$sql = "UPDATE manufacture SET manufac_status='$manufac_status' WHERE manufac_id='$manufac_id'";
	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':manufac_status'=>$manufac_status)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$manufac_id.$manufac_status อัพเดทสถานะเรียบร้อยแล้ว!')</script>";
	   echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=manufacture'>" ;
	}
	else
	{
		echo 'แก้ไขข้อมูลไม่สำเร็จ.';
	}
}
///////////////////////////////////END////////////////////////////////////////////
////////////////Cancle manufac row Restore raw material for rawmaterial table/////
if (isset($_GET['Cancle_manufac'])) 
{
	$manufac_id = $_GET['Cancle_manufac'];//getting id of the data from url
	//select status column for manufac table where id
	$sql = 'SELECT manufac_status FROM manufacture WHERE manufac_id=:manufac_id'; 
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':manufac_id' => $manufac_id]);
		while($row = $stmt->fetch(PDO::FETCH_OBJ))
		{
			if ($row->manufac_status =='ยกเลิก')
			{

			}
			else
			{		//update status = cancle where id
				$sql = "UPDATE manufacture SET manufac_status='ยกเลิก' WHERE manufac_id='$manufac_id'";
				$stmt2 = $db->prepare($sql);
				$result = $stmt2->execute(array(':manufac_id'=>$manufac_id)); //5
					//select  manufac_QtyrMtr, descmtr_fid column from desc_manufac table where Fk=Pk
				$sql = "SELECT manufac_QtyrMtr, descmtr_fid FROM desc_manufac WHERE descmnf_fid='$manufac_id'";
				$stmt3 = $db->prepare($sql);   //เตรียมคำสั่ง SQL
				$stmt3->execute();
				while($row = $stmt3->fetch(PDO::FETCH_OBJ))
				{		//Restere for rawmaterial table SET Qty + $row->manufac_QtyrMtr where Pk=Fk[row]
					$sql ="UPDATE rawmaterial SET matr_quantity = matr_quantity + $row->manufac_QtyrMtr 
					WHERE matr_id =$row->descmtr_fid";
					$stmtraw = $db->prepare($sql);
					$stmtraw->execute();
				}
				echo "<script language='javascript' type='text/javascript'>
		alert('$manufac_id ยกเลิกเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=manufacture'>" ;
			}
		}

}
///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////Delete manufac row/////////////////////////
if(isset($_GET['manufac_id']))
{
	//getting id of the data from url
	$manufac_id = $_GET['manufac_id'];
		//Delete 2 table are manufac & desc_manufa table//
	$sql = "DELETE manufacture, desc_manufac  FROM manufacture  INNER JOIN desc_manufac 
	WHERE  manufacture.manufac_id = desc_manufac.descmnf_fid and manufacture.manufac_id=:manufac_id";
	$query = $db->prepare($sql);
	$query->execute(array(':manufac_id' => $manufac_id));
	if ($query)
	{
		echo "<script language='javascript' type='text/javascript'>
		alert('$manufac_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=manufacture'>" ;
	}
}
////////////////////////////////END//////////////////////////////////////////////////
////////////////////////manufac delete multi reccord////////////////////////////////////////////////
if(isset($_POST['datamanufac'])){
	$dataArr = $_POST['datamanufac']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM manufacture WHERE manufac_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
/////////////////////////////////////////////////////////////////////////////////////

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
	$staffsalary_fid = $_POST['staffsalary_fid'];

$sql = "UPDATE payrollstaff SET salary_paydate='$salary_paydate', salary_payroll='$salary_payroll',
 salary_status='$salary_status', salary_ovtWdr='$salary_ovtWdr', salary_receiveAm='$salary_receiveAm', 
 salary_total='$salary_total', staffsalary_fid='$staffsalary_fid' 
  WHERE salary_id='$salary_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':salary_id'=>$salary_id, 
		':salary_paydate'=>$salary_paydate, ':salary_payroll'=>$salary_payroll, 
		':salary_status'=>$salary_status, ':salary_ovtWdr'=>$salary_ovtWdr, ':salary_receiveAmr'=>$salary_receiveAm, ':salary_total'=>$salary_total, ':staffsalary_fid'=>$staffsalary_fid)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$salary_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
	   echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=salary'>" ;
	}
	else
	{
		echo 'แก้ไขข้อมูลไม่สำเร็จ.';
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
			echo "<script language='javascript' type='text/javascript'>alert('$salary_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=salary'>" ;
		}
}
/////////////////////////////////////END////////////////////////////////////////////////
////////////////////////staff delete multi rows//////////////////
if(isset($_POST['datasalary'])){
	$dataArr = $_POST['datasalary']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM payrollstaff WHERE salary_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
///////////////////////////////////////////////////////////////
//Edit work////////////////////////////
if(isset($_POST['workupdate']))
{
	$work_id = $_POST['work_id'];
	$work_date = $_POST['work_date'];
	$work_dayoff = $_POST['work_dayoff'];
	$work_time = $_POST['work_time'];

$sql = "UPDATE work SET work_date='$work_date', work_dayoff='$work_dayoff',
 work_time='$work_time' WHERE work_id='$work_id'";

	$stmt = $db->prepare($sql);
	$result = $stmt->execute(array(':work_id'=>$work_id, ':work_date'=>$work_date, 
		':work_dayoff'=>$work_dayoff, ':work_time'=>$work_time)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$work_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";
	   echo "<meta http-equiv='refresh' content='1; url = ../Project/index.php?page=work'>" ;
	}
	else
	{
		echo 'ลบข้อมูลเรียบร้อยแล้ว.';
	}
}
//////////////////////END//////////////////////////////////
///////////////////Delete work////////////////////////////
if(isset($_GET['work_id']))
{
	//getting id of the data from url
	$work_id = $_GET['work_id'];

	//deleting the row from table inventory
	$sql = "DELETE FROM work WHERE work_id='$work_id'";
	$query = $db->prepare($sql);
	$query->execute(array(':work_id' => $work_id));
		if ($query)
		{
			echo "<script language='javascript' type='text/javascript'>alert('$work_id Successfully Delete!')</script>";
			echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=work'>" ;
		}
}
/////////////////END////////////////////////////////////
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
	   echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=finance'>" ;
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>alert('$account_id แก้ไขข้อมูลไม่สำเร็จ')</script>";
	   echo "<meta http-equiv='refresh' content='1; url = ../index.php?page=addnewAccount'>" ;
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
			echo "<script language='javascript' type='text/javascript'>alert('$account_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='0.5; url = ../index.php?page=finance'>" ;
		}
}
///////////////////////////////END/////////////////////////////////////////////////////////////
////////////////////////account delete multi rows//////////////////
if(isset($_POST['dataaccount'])){
	$dataArr = $_POST['dataaccount']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM account WHERE account_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
///////////////////////////////////////////////////////////////

//Edit machine row//
if(isset($_POST['machineupdate']))
{

	$maintn_id = $_POST['maintn_id'];
	$maintn_title = $_POST['maintn_title'];
	$maintn_date = $_POST['maintn_date'];
	$maintn_desc = $_POST['maintn_desc'];
	$maintn_name = $_POST['maintn_name'];
	$maintn_phone = $_POST['maintn_phone'];
	$maintnstaff_fid = $_POST['maintnstaff_fid'];

							//column name=variable//
	$sql = "UPDATE maintenance SET maintn_title='$maintn_title', maintn_date='$maintn_date', maintn_desc='$maintn_desc', maintn_name='$maintn_name', maintn_phone='$maintn_phone', maintnstaff_fid='$maintnstaff_fid' WHERE maintn_id='$maintn_id'";

	$stmt = $db->prepare($sql);            ////3
	$result = $stmt->execute(array(':maintn_id'=>$maintn_id, ':maintn_title'=>$maintn_title, 
		':maintn_date'=>$maintn_date, ':maintn_desc'=>$maintn_desc, 
		':maintn_name'=>$maintn_name, ':maintn_phone'=>$maintn_phone, ':maintnstaff_fid'=>$maintnstaff_fid)); //5

	if($result)
	{
	   echo "<script language='javascript' type='text/javascript'>alert('$maintn_id แก้ไขข้อมูลเรียบร้อยแล้ว!')</script>";

		echo "<meta http-equiv='refresh' content='0; url = ../index.php?page=repairmachine'>" ;
	}
	else
	{
		echo 'แก้ไขข้อมูลไม่สำเร็จ.';
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
			echo "<script language='javascript' type='text/javascript'>alert('$maintn_id ลบข้อมูลเรียบร้อยแล้ว!')</script>";
			echo "<meta http-equiv='refresh' content='1; url = /Project/index.php?page=repairmachine" ;
		}
}
//////////////////////////////////END/////////////////////////////////////////////////
////////////////////////account delete multi rows//////////////////
if(isset($_POST['dataMtn'])){
	$dataArr = $_POST['dataMtn']; 

	foreach($dataArr as $id){
		$sql = "DELETE FROM maintenance WHERE maintn_id='$id'";
		$query = $db->prepare($sql);
		$query->execute();
	}
	echo 'ลบข้อมูลเรียบร้อยแล้ว';
}
//////////////////////End/////////////////////////////////////////
//////////////////////////////producttype Edit///////////////////////////////
if(isset($_POST['updateProducttype']))
{
	$producttype_id = $_POST['producttype_id'];
	$producttype_name = $_POST['producttype_name'];

							//column name=variable//
	$sql = "UPDATE producttype SET producttype_name='$producttype_name' WHERE producttype_id='$producttype_id'";
	$stmt = $db->prepare($sql);            ////3
	$result = $stmt->execute(array(':producttype_id'=>$producttype_id, ':producttype_name'=>$producttype_name));

	if($result)
	{
	  echo "<script>alert('$producttype_name. เพิ่มข้อมูลสำเร็จ')</script>";
			echo "<meta http-equiv='refresh' content='0; url = index.php?page=producttype'>" ;
	}
	else
	{
		echo "<script>alert('$producttype_name. เพิ่มข้อมูลสำเร็จ')</script>";
			echo "<meta http-equiv='refresh' content='0; url = index.php?page=producttypeEditform'>" ;
	}
}
/////////////////////////////////////////END/////////////////////////////////////////////
ob_end_flush();
?>
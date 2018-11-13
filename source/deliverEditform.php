<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$deliver_id = $_GET['deliver_id'];    //getting id from url

	$sql = 'SELECT * FROM delivery WHERE deliver_id=:deliver_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':deliver_id' => $deliver_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);
/////////////////////////////foreign key////////////////////////////////////
/////////////////////////////////select staff table///
/////////////////////////////////select staff table///
$sql = "SELECT * FROM staff";
$stmtstf = $db->prepare($sql);
$stmtstf->execute();
$resultstf = $stmtstf->fetchAll(PDO::FETCH_ASSOC);
/////////////////////////////END////////////////////
/////////////////select sell table/////////////////
$sql = "SELECT desc_sell.*, product.product_name, sell.sell_status 
FROM desc_sell 
INNER JOIN product ON desc_sell.product_fid = product.product_id
INNER JOIN sell ON desc_sell.sell_fid = sell.sell_id 
WHERE NOT sell_status='ยกเลิก' AND NOT sell_status='รอชำระเงิน'";
$stmtsell = $db->prepare($sql);
$stmtsell->execute();  ///stmt = statement
$resultsell = $stmtsell->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Delivery data</title>
   <link rel="stylesheet" type="text/css" href="/Project/CSS/form.css"><!--form used-->
<script type="text/javascript">   //no refresh page when submit
  $(document).ready(function() {
    $('#myForm').ajaxForm({
      target: '#showdata',
      success: function() {
        $('#showdata').fadeIn('slow');
      }
    });
  });
  </script>
</head>
<body>
<!--Content!-->
<div class="main">
	<b><h3>แก้ไขข้อมูลการจัดส่ง</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลการจัดส่ง</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="deliver_id" placeholder="" value="<?php echo $select->deliver_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่จัดส่ง :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="deliver_date" placeholder="" value="<?php echo $select->deliver_date; ?>" required>
	    </div>
	  </div>

	   <!--foreign key staff-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสการขาย :</label>
	    <div class="col-sm-10">
	      <select class="form-control" name="deliver_sellid" style="font-family: Mitr" id="myForm" required >
	      	<option value="" disabled="disabled" selected>--เลือกรหัสการขาย&nbsp;|&nbsp;สินค้าที่ขายแล้ว--</option>
	    <?php foreach($resultsell as $rowsell )  {?>
	      	<option required value="<?php echo $rowsell['sell_fid']; ?>" 
	      		<?php if ($resultsell == $rowsell['sell_fid']) { echo 'selected'; } ?>>
	      		<?php echo $rowsell['sell_fid'].'.&nbsp;'.$rowsell['product_name'].'&nbsp;|&nbsp;'
	      		.$rowsell['sell_status']; ?>
	      	</option>
	   <?php } ?>
  		</select>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จัดส่งโดย :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="deliver_by" placeholder="" value="<?php echo $select->deliver_by; ?>" required>
	    </div>
	  </div>
	 				<!--foreign key staff-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสพนักงาน :</label>
	    <div class="col-sm-10">
	      <select class="form-control" name="deliver_stafffid" style="font-family: Mitr" id="myForm" required >
	      	<option value="ไม่ได้เลือก" name="deliver_stafffid">--เลือกรหัสพนักงาน&nbsp;|&nbsp;ชื่อพนักงาน--</option>
	    <?php foreach($resultstf as $rowstf ) {?>
	      	<option required value="<?php echo $rowstf['staff_id']; ?>" 
	      		<?php if ($resultstf == $rowstf['staff_id']) { echo 'selected'; } ?>>
	      		<?php echo $rowstf['staff_id'].'.'.$rowstf['staff_name']; ?>
	      	</option>
	   <?php
	}
	   ?>
  		</select>
	    </div>
	  </div>
	  			<!--END foreign key product type-->
	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะจัดส่ง :</label>
	    <div class="col-sm-10">
	      <select name="deliver_status" class="custom-select" id="input" style="font-family: Mitr">
	      	<option value="" disabled="disabled" selected>--เลือกสถานะจัดส่ง--</option>
		    <option name="deliver_status" value="จัดส่งแล้ว" 
		    <?php if($select->deliver_status =='จัดส่งแล้ว'){ echo "selected='selected'";}?>>จัดส่งเรียบร้อยแล้ว</option>
  		</select>
	    </div>
	  </div>


	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="deliverupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
	     </input>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
	  </div>
	    </div>
	</div>
</form>
	<div id="showdata">
  		<? include("../Project/source/edit.php");?>
  	</div>
</script>
</div>
</body>
</html>
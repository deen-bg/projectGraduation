<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$defective_id = $_GET['defective_id'];    //getting id from url

	$sql = 'SELECT * FROM defective WHERE defective_id=:defective_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':defective_id' => $defective_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM product";
$stmtpd = $db->prepare($sql);
$stmtpd->execute();  ///stmt = statement
$result = $stmtpd->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit defective product</title>
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
	<b><h3>แก้ไขข้อมูลสินค้าชำรุด</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post"s>
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลสินค้าชำรุด</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="defective_id" placeholder="" value="<?php echo $select->defective_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวน :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="defective_amount" placeholder="" value="<?php echo $select->defective_amount; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ยอดรวม :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="defective_total" placeholder="" value="<?php echo $select->defective_total; ?>" required>
	    </div>
	  </div>

	  				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสสินค้า :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="pddefective_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกรหัสสินค้า</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['product_id']; ?>" <?php if ($result == $rows['product_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['product_id']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="defectiveupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
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
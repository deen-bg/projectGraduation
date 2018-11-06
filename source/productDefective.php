<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;

$sql = "SELECT * FROM product";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Delivery Form</title>
	   <link rel="stylesheet" type="text/css" href="/Project/CSS/form.css"><!--form used-->
<!--no refresh page when submit!-->
<script type="text/javascript">
  $(document).ready(function() {
    $('#myForm').ajaxForm({
      target: '#showdata',
      success: function() {
        $('#showdata').fadeIn('slow');
      }
    });
  });
  </script>
<!--end-->
</head>
<body>
<!--Content!-->
<div class="main">
	<b><h3>ข้อมูลสินค้าชำรุด</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิมข้อมูลสินค้าชำรุด</h4></b>
		</div>

	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="defective_id" placeholder="รหัสสินค้าชำรุด">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">จำนวน :</label>
	  	<div class="col-sm-10">
	  		<input type="number" class="form-control" id="input" name="defective_amount" placeholder="ตัวเลขเท่านั้น">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รวมค่าเสียหาย :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="defective_total" placeholder="ตัวเลขเท่านั้น(THB.)" required>
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
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="defectsubmit" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
	  	</div>
	    </div>
	</div>
</form>
<br>
<br>
<br>
<br>
<br>
<br>
<div id="showdata">
    <?include("../Project/database/insert.php");?>
  </div>
</div>
</body>
</html>

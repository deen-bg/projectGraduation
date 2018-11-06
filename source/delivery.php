<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
/////////////////////////////////select staff table///
$sql = "SELECT * FROM staff";
$stmtstf = $db->prepare($sql);
$stmtstf->execute();
$resultstf = $stmtstf->fetchAll(PDO::FETCH_ASSOC);
/////////////////////////////END////////////////////
/////////////////select sell table/////////////////
$sql = "SELECT * FROM desc_sell";
$stmtsell = $db->prepare($sql);
$stmtsell->execute();  ///stmt = statement
$resultsell = $stmtsell->fetchAll(PDO::FETCH_ASSOC);
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
	<b><h3>ข้อมูลการจัดส่ง</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลการจัดส่ง</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="deliver_id" placeholder="รหัสการจัดส่ง">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">วันที่จัดส่ง :</label>
	  	<div class="col-sm-10">
	  		<input type="date" class="form-control" id="input" name="deliver_date" placeholder="วันที่จัดส่ง">
	  	</div>
	  </div>

	   <!--foreign key staff-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสการขาย :</label>
	    <div class="col-sm-10">
	      <select class="form-control" name="deliver_sellid" style="font-family: Mitr" id="myForm" required >
	      	<option value="" selected>--เลือกรหัสการขาย&nbsp;|&nbsp;สินค้าที่ขายแล้ว--</option>
	    <?php foreach($resultsell as $rowsell ) {?>
	      	<option required value="<?php echo $rowsell['sell_fid']; ?>" 
	      		<?php if ($resultsell == $rowsell['sell_fid']) { echo 'selected'; } ?>>
	      		<?php echo $rowsell['sell_fid'].'.'.$rowsell['product_fid']; ?>
	      	</option>
	   <?php
	}
	   ?>
  		</select>
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จัดส่งโดย :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="deliver_by" placeholder="จัดส่งโดย" required>
	    </div>
	  </div>

	 				<!--foreign key staff-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสพนักงาน :</label>
	    <div class="col-sm-10">
	      <select class="form-control" name="deliver_stafffid" style="font-family: Mitr" id="myForm" required >
	      	<option value="" selected>--เลือกรหัสพนักงาน&nbsp;|&nbsp;ชื่อพนักงาน--</option>
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

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="deliversubmit" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
	  </div>
	    </div>
	</div>
</form>
<br>
<br>
<div id="showdata">
    <?include("../Project/database/insert.php");?>
  </div>
</div>

</body>
</html>

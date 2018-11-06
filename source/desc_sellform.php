<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
//////////////////////////Select table producttype//////////
$sql = "SELECT * FROM product";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
////////////////END//////////////////////////////////////
/////////////////////Select table manufacture////////////////
$sql = "SELECT * FROM sell";
$stmtsell = $db->prepare($sql);
$stmtsell->execute();  ///stmt = statement
$resultsell = $stmtsell->fetchAll(PDO::FETCH_ASSOC);
///////////////////END////////////////////////////////////
?>

<!DOCTYPE html>
<html>
<head>
	<title>Desc selling Form</title>
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
	<b><h3>ข้อมูลรายละเอียดการขาย</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php " method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลรายละเอียดการขาย</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="descsell_id" placeholder="รหัสรายละเอียดการขาย">
	  	</div>
	  </div>
					<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสสินค้า :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="product_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกรหัสสินค้า</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['product_id']; ?>" <?php if ($result == $rows['product_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['product_id'].'.'.$rows['product_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->
					<!--foreign key Manufacture-->
	<div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสการขาย :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="sell_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกรหัสการขาย</option>
	    <?php foreach($resultsell as $rowsell ) {?>
	      	<option value="<?php echo $rowsell['sell_id']; ?>" 
	      		<?php if ($resultsell == $rowsell['sell_id']) { echo 'selected'; } ?>>
	      		<?php echo $rowsell['sell_id']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
						<!--END foreign key Manufacture-->
	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="submitdescsell" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=product"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
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

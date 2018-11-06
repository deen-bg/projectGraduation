<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;

$sql = "SELECT * FROM manufacture";
$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Row material Form</title>
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
	<b><h3>ข้อมูลวัตถุดิบ</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">ข้อมูลวัตถุดิบ</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="matr_id" placeholder="รหัสวัตถุดิบ">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อวัตถุดิบ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="matr_name" placeholder="ชื่อวัตถุดิบ" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่นำเข้า :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="matr_impdate" placeholder="วันที่นำเข้า" required>
	    </div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวน :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="matr_quantity" placeholder="ตัวเลขเท่านั้น" required>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ราคาต่อหน่วย :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="matr_price" placeholder="total">
	    </div>
	  </div>

	  					<!--foreign key manufacture id-->
	<!--  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสการผลิต :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="rawmaterial_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกรหัสการผลิต</option>
	    <?php// foreach($result as $rows ) {?>
	      	<option required value="<?php //echo $rows['manufac_id']; ?>" <?php if ($result == $rows['manufac_id']) {// echo 'selected'; } ?>>
	      		<?php// echo $rows['manufac_id'].'.'.$rows['manufac_date']; ?>
	      	</option>//
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key manufacture id-->

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="submitmatr" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=material"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
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

<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Staff salary Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="/Project/CSS/Form_login.css"><!--navbar used!-->
  	<link rel="stylesheet" type="text/css" href="./CSS/form.css"><!--form used!-->
 	<script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery.form.js"></script><!--no refresh form!-->

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
	<b><h3>ข้อมูลบัญชีรายรับ-รายจ่าย</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลรายรับ-รายจ่าย</h4></b>
		</div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">รหัสบัญชี :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="finance_id" placeholder="รหัสบัญชี">
	  	</div>
	  </div>

	   <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">วันที่ :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="finance_day" placeholder="วันที่">
	  	</div>
	  </div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">เดือน :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="finance_month" placeholder="เดือน">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">ปี :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="finance_year" placeholder="ปี">
	  	</div>
	  </div>

	 <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="finance_desc" placeholder="รายละเอียด" required></textarea>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ประเภทรายการ :</label>
	    <div class="col-sm-10">
	      <select class="custom-select" id="input" style="font-family: Mitr">
	      	<option selected>เลือกประเภทรายการ</option>
		    <option value="finance_type">รายรับ</option>
		    <option value="finance_type">รายจ่าย</option>
  		</select>
	    </div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">จำนวนเงิน :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="finance_total" placeholder="จำนวนเงิน">
	  	</div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="button" value="" class="btn btn-primary btn-md">บันทึก</button></a>
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

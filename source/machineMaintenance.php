<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Machine Maintenance Form</title>
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
	<b><h3>ข้อมูลบำรุงรักษาเครื่องจักร</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลบำรุงรักษาเครื่องจักร</h4></b>
		</div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">รหัสซ่อมบำรุง :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="maintn_id" placeholder="รหัสซ่อมบำรุง">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">วันที่ซ่อม :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="maintn_date" placeholder="วันที่ซ่อม">
	  	</div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียดซ่อม :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="maintn_desc" placeholder="รายละเอียดซ่อม" required></textarea>
	    </div>
	  </div>


	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">ค่าใช้จ่าย :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="maintn_cost" placeholder="ค่าใช้จ่าย">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">ชื่อผู้ซ่อม :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="maintn_name" placeholder="ชื่อผู้ซ่อม">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">เบอร์ติดต่อ :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="maintn_phone" placeholder="เบอร์ติดต่อ">
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

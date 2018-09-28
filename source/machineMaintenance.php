<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="/Project/CSS/Form_login.css">
 	<script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery.form.js"></script>
<style>
form {
	background-color: #FFFFFF;
	padding-top: 20px;
	padding-right: 20px;
	padding-bottom: 20px;
	padding-left: 40px;
	border-radius: 20px;
	margin-top: 50px;
	text-decoration: none;
	overflow: hidden;
}
button {
	background-color: #21BAA1;
	float: right;
	width: 80px
}
#fh4 {
	padding-bottom: 50px;
	color: #21BAA1;
}
h3 {
	color: #2C394F;
}
#input {
	border-radius: 100px;
	background-color: #F2F2F2;
}
</style>

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
	<b><h3>ข้อมูลแจ้งการซ่อมบำรุงเครื่องจักร</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลการซ่อมบำรุงเครื่องจักร</h4></b>
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
	      <input type="date" class="form-control" id="input" name="maintn_date" placeholder="ชื่อลูกค้า" required>
	    </div>
	  </div>


	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="maintn_desc" placeholder="รายละเอียด" required></textarea>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อผู้ซ่อม :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="maintn_name" placeholder="ชื่อผู้ซ่อม">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เบอร์โทร :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="maintn_phone" placeholder="เบอร์โทร">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="submitmaintenance" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=repairmachine"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
	  </div>
	    </div>
	</div>
</form>
<div id="showdata">
    <?include("../Project/database/insert.php");?>
  </div>
</div>
</body>
</html>

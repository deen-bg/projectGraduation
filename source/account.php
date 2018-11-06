<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Form</title>
	<script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
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
	<b><h3>ข้อมูลบัญชีรายรับ-รายจ่าย</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลรายรับ-รายจ่าย</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="account_id" placeholder="รหัสบัญชี">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="account_date" placeholder="วันที่" required>
	    </div>
	  </div>
	<div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ปี :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="account_year" placeholder="ปี">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="account_desc" placeholder="รายละเอียด" required></textarea>
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ประเภทรายการ :</label>
	    <div class="col-sm-10">
	      <select name="account_itemtype" class="custom-select" id="input" style="font-family: Mitr">
	      	<option selected>เลือกประเภทรายการ</option>
		    <option name="account_itemtype" value="รายรับ">รายรับ</option>
		    <option name="account_itemtype" value="รายจ่าย">รายจ่าย</option>
  		</select>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ยอดรวม :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="account_total" placeholder="ยอดรวม(THB.)">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="submitaccount" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=repairmachine"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
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

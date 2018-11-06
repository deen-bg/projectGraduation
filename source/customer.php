<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Form</title>
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
	<b><h3>ข้อมูลลูกค้า</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">ข้อมูลลูกค้า</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="cus_id" placeholder="รหัสลูกค้า">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อลูกค้า :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="cus_name" placeholder="ชื่อลูกค้า" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">นามสกุล :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="cus_surname" placeholder="นามสกุล" required>
	    </div>
	  </div>
			<!--Radio button !-->
	  <fieldset class="form-group">
	    <div class="row">
	      <legend class="col-form-label col-sm-2 pt-0">เพศ :</legend>
	      <div class="col-sm-10">
	        <div class="form-check">
	          <input class="form-check-input" type="radio" name="gen_radio" id="gridRadios1" value="male" checked>
	          <label class="form-check-label" for="gridRadios1">ชาย</label>
	        </div>
	        <div class="form-check">
	          <input class="form-check-input" type="radio" name="gen_radio" id="gridRadios2" value="female">
	          <label class="form-check-label" for="gridRadios2">หญิง</label>
	        </div>
	      </div>
	    </div>
	  </fieldset>
	  		<!--End Radio button!-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">อีเมล์ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="cus_mail" placeholder="อีเมล์" required>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เบอร์โทร :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="cus_phone" placeholder="ตัวเลขเทา่นั้น">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ที่อยู่ :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="cus_add" placeholder="ที่อยู่" required></textarea>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="submitcustomer" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=customer"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
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

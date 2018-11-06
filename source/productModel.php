<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Product model Form</title>
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
	<b><h3>ข้อมูลแบบผลิตภัณฑ์</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post" target="blank" enctype="multipart/form-data">
		 <div class="form-group row">
			<b><h4 id="fh4">ข้อมูลแบบผลิตภัณฑ์</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="pmodel_id" placeholder="รหัสแบบผลิตภัณฑ์">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อผลิตภัณฑ์ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="pmodel_name" placeholder="ชื่อผลิตภัณฑ์" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label" >รูปภาพ :</label>
	    <div class="col-sm-10">
	      <div class="custom-file">
			  <input type="file" class="custom-file-input" name="pmodel_img" id="" accept="image/*">
			  <label class="custom-file-label" for="customFile" id="myForm">เลือกไฟล์</label>
			</div>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="pmodel_desc" placeholder="รายละเอียด" required></textarea>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="pmodelsubmit" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
	  </div>
	    </div>
	</div>
</form>
<br>
<br>
<div id="showdata">
    <?include("../database/insert.php");?>
  </div>
</div>

</body>
</html>

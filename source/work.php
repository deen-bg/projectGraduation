<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;

$sql = "SELECT * FROM staff";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Work Form</title>
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
	<b><h3>ข้อมูลการทำงาน</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php " method="post" enctype="multipart/form-data">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลการทำงาน</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="work_id" placeholder="รหัสการทำงาน">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ทำงาน :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="work_date" placeholder="วันที่ทำงาน" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวนวันลางาน :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="work_dayoff" placeholder="ตัวเลขเท่านั้น" required>
	    </div>
	  </div>
	
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เวลาเข้างาน:</label>
	    <div class="col-sm-10">
	      <input type="time" class="form-control" id="input" name="work_time" placeholder="จำนวน" required>
	    </div>
	  </div>

	  				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสพนักงาน :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="staff_fid" value=' ' style="font-family: Mitr">
	      	<option value="" selected>เลือกรหัสพนักงาน</option>
	    <?php foreach($result as $rows ) {?>
	      	<option required value="<?php echo $rows['staff_id']; ?>" <?php if ($result == $rows['staff_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['staff_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key staff-->

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="submitwork" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=product"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
	  </div>
	    </div>
	</div>
</form>
<br>
<br>
<br>
<div id="showdata">
    <?include("../Project/database/insert.php");?>
  </div>
</div>
</body>
</html>

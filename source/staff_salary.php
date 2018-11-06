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
	<title>Staff salary Form</title>
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
	<b><h3>ข้อมูลการจ่ายเงินเดือนพนักงาน</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลการจ่ายเงินเดือนพนักงาน</h4></b>
		</div>
		 <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="salary_id" placeholder="รหัสการเบิกจ่าย">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">วันที่จ่ายเงินเดือน :</label>
	  	<div class="col-sm-10">
	  		<input type="date" class="form-control" id="input" name="salary_paydate" placeholder="วันที่จ่ายเงินเดือน">
	  	</div>
	  </div>

	  				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหสัพนักงาน :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="staffsalary_fid" value=' ' style="font-family: Mitr" id="myForm" required="">
	      	<option value="" selected>เลือกรหัสพนักงาน</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['staff_id']; ?>" <?php if ($result == $rows['staff_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['staff_id'].'.'.$rows['staff_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>

	  		<!--Auto calculate minus-->
	  <script type="text/javascript">
	  	$(function () 
	  	{
	  			$("#salary, #resiptOvt, #receiveAM").keyup(function () 
  			{
    			$("#total, #receiveAM").val(+$("#salary").val() - +$("#resiptOvt").val());
  			});

		});
	  </script>
					<!--END foreign key product type-->
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">ค่าจ้าง :</label>
	  	<div class="col-sm-10">
	  		<input type="number"  id="salary" class="form-control" id="input" name="salary_payroll" placeholder="ตัวเลขเท่านั้น">
	  	</div>
	  </div>

	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">จำนวนเงินที่เบิกล่วงหน้า :</label>
	  	<div class="col-sm-10">
	  		<input type="number" id="resiptOvt" class="form-control" id="input" name="salary_ovtWdr" placeholder="ตัวเลขเท่านั้น">
	  	</div>
	  </div>

	   <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">จำนวนเงินที่ได้รับรับ :</label>
	  	<div class="col-sm-10">
	  		<input type="number" id="receiveAM" readonly class="form-control" id="input" name="salary_receiveAm" placeholder="ตัวเลขเท่านั้น">
	  	</div>
	  </div>

	   <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">ยอดรวมสุทธิ :</label>
	  	<div class="col-sm-10">
	  		<input type="number" id="total" readonly class="form-control" id="input" name="salary_total" placeholder="ตัวเลขเท่านั้น">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะการรับเงิน :</label>
	    <div class="col-sm-10">
	      <select name="salary_status" class="custom-select" id="input" style="font-family: Mitr">
	      	<option selected>เลือกสถานะ</option>
		    <option name="salary_status" value="ยังไม่ได้รับ">ยังไม่ได้รับ</option>
		    <option name="salary_status" value="ได้รับแล้ว">ได้รับแล้ว</option>
  		</select>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="#"><button type="submit" name="salarysubmit" value="" class="btn btn-primary btn-md">บันทึก</button></a>
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
<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$salary_id = $_GET['salary_id'];    //getting id from url

	$sql = 'SELECT * FROM payrollstaff WHERE salary_id=:salary_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':salary_id' => $salary_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM staff";
$stmtsalary = $db->prepare($sql);
$stmtsalary->execute();  ///stmt = statement
$result = $stmtsalary->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Selling</title>
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
	<b><h3>แก้ไขข้อมูลการเบิกจ่ายเงินเดือนพนักงาน</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลการเบิกจ่ายเงินเดือนพนักงาน</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="salary_id" placeholder="" value="<?php echo $select->salary_id; ?>">
	  	</div>

	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่จ่ายเงินเดือน :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="salary_paydate" placeholder="" value="<?php echo $select->salary_paydate; ?>" required>
	    </div>
	  </div>

	  			<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหสัพนักงาน :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="staffsalary_fid" value=' ' style="font-family: Mitr" id="myForm" required="">
	      	<option value="" selected>เลือกรหัสพนักงาน</option>
	    <?php foreach($result as $rows ) {?>
	      	<option required value="<?php echo $rows['staff_id']; ?>" <?php if ($result == $rows['staff_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['staff_id'].'.'.$rows['staff_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->
		
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

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ค่าจ้าง :</label>
	    <div class="col-sm-10">
	      <input type="number" id="salary" class="form-control" id="input" name="salary_payroll" placeholder="นามสกุล" value="<?php echo $select->salary_payroll; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เบิกล่วงหน้า :</label>
	    <div class="col-sm-10">
	      <input type="number" id="resiptOvt" class="form-control" id="input" name="salary_ovtWdr" placeholder="เบอร์โทร" value="<?php echo $select->salary_ovtWdr; ?>">
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวนเงินที่รับ :</label>
	    <div class="col-sm-10">
	      <input type="number" id="receiveAM" class="form-control" id="input" name="salary_receiveAm" placeholder="เบอร์โทร" value="<?php echo $select->salary_receiveAm; ?>">
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ยอดรวมสุทธิ :</label>
	    <div class="col-sm-10">
	      <input type="number" id="total" class="form-control" id="input" name="salary_total" placeholder="เบอร์โทร" value="<?php echo $select->salary_total; ?>">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะการรับเงิน :</label>
	    <div class="col-sm-10">
	      <select name="salary_status" class="custom-select" id="input" style="font-family: Mitr">
		    <option name="salary_status" value="ยังไม่ได้รับ" <?php if($select->salary_status =='ยังไม่ได้รับ'){ echo "selected='selected'";}?>>ยังไม่ได้รับ</option>
		    <option name="salary_status" value="ได้รับแล้ว" <?php if($select->salary_status =='ได้รับแล้ว'){ echo "selected='selected'";}?>>ได้รับแล้ว</option>
		}?>
  		</select>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<a href="index.php?page=button"><button type="submit" name="selaryupdate" value="" class="btn btn-primary btn-md">อัพเดท</button></a>
	     </input>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=salary"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
	  </div>
	    </div>
	</div>
</form>
<br>
<br>
<br>
	<div id="showdata">
  		<? include("../Project/source/edit.php");?>
  	</div>
</script>
</div>
</body>
</html>
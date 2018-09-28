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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Selling</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="" content="text/html; charset=UTF-8">
  	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="/Project/CSS/Form_login.css">
  	<link rel="stylesheet" type="text/css" href="./CSS/form.css"><!--form used!-->
 	<script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery.form.js"></script>

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
	<form id="myForm" class="" action="./source/edit.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลการเบิกจ่ายเงินเดือนพนักงาน</h4></b>
		</div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">รหัสเบิกจ่าย :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="salary_id" placeholder="" value="<?php echo $select->salary_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่จ่ายเงินเดือน :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="salary_paydate" placeholder="" value="<?php echo $select->salary_paydate; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เงินเดือน :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="salary_payroll" placeholder="นามสกุล" value="<?php echo $select->salary_payroll; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะการรับเงิน :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="salary_status" placeholder="อีเมล์" value="<?php echo $select->salary_status; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เบิกล่วงหน้า :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="salary_ovtWdr" placeholder="เบอร์โทร" value="<?php echo $select->salary_ovtWdr; ?>">
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวนเงินที่รับ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="salary_receiveAm" placeholder="เบอร์โทร" value="<?php echo $select->salary_receiveAm; ?>">
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ยอดรวมสุทธิ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="salary_total" placeholder="เบอร์โทร" value="<?php echo $select->salary_total; ?>">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<a href="index.php?page=button"><button type="submit" name="selaryupdate" value="" class="btn btn-primary btn-md">อัพเดท</button></a>
	     </input>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
	  </div>
	    </div>
	</div>
</form>
	<div id="showdata">
  		<? include("../Project/source/edit.php");?>
  	</div>
</script>
</div>
</body>
</html>
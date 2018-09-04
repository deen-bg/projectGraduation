<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$cus_id = $_GET['cus_id'];    //getting id from url

	$sql = 'SELECT * FROM customer WHERE cus_id=:cus_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':cus_id' => $cus_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

?>


<!DOCTYPE html>
<html>
<head>
	<title>Edit data Customer</title>
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
	<b><h3>แก้ไขข้อมูลลูกค้า</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลลูกค้า</h4></b>
		</div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">รหัสลูกค้า :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="cus_id" placeholder="รหัสลูกค้า" value="<?php echo $select->cus_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อลูกค้า :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="cus_name" placeholder="ชื่อลูกค้า" value="<?php echo $select->cus_name; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">นามสกุล :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="cus_surname" placeholder="นามสกุล" value="<?php echo $select->cus_surname; ?>" required>
	    </div>
	  </div>
			<!--Radio button !-->
	  <fieldset class="form-group">
	    <div class="row">
	      <legend class="col-form-label col-sm-2 pt-0">เพศ :</legend>
	      <div class="col-sm-10">
	        <div class="form-check">
	          <input class="form-check-input" type="radio" name="gen_radio" id="gridRadios1" value="male" >
	          <label class="form-check-label" for="gridRadios1" >ชาย</label>
	        </div>
	        <div class="form-check">
	          <input class="form-check-input" type="radio" name="gen_radio" id="gridRadios2" value="female" >
	          <label class="form-check-label" for="gridRadios2">หญิง</label>
	        </div>
	      </div>
	    </div>
	  </fieldset>
	  		<!--End Radio button!-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">อีเมล์ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="cus_mail" placeholder="อีเมล์" value="<?php echo $select->cus_mail; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เบอร์โทร :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="cus_phone" placeholder="เบอร์โทร" value="<?php echo $select->cus_phone; ?>">
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ที่อยู่ :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="cus_add" placeholder="ที่อยู่" value="" required><?php echo $select->cus_add; ?></textarea>
	    </div>
	  </div>
	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="update" value="" class="btn btn-primary btn-md">อัพเดท</button>
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
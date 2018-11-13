<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$manufac_id = $_GET['manufac_id'];    //getting id from url

	$sql = 'SELECT * FROM manufacture WHERE manufac_id=:manufac_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':manufac_id' => $manufac_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

///////////////////////////select product table/////////
$sql = "SELECT * FROM product";
$stmtpd = $db->prepare($sql);
$stmtpd->execute();  ///stmt = statement
$resultpd = $stmtpd->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM staff";
$stmtstaff = $db->prepare($sql);
$stmtstaff->execute();  ///stmt = statement
$result = $stmtstaff->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM rawmaterial";
$stmtMtr = $db->prepare($sql);
$stmtMtr->execute();  ///stmt = statement
$resultMtr = $stmtMtr->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Manufacture</title>
	        <link rel="stylesheet" type="text/css" href="/Project/CSS/form.css"><!--form used-->
	        <script type="text/javascript" src="/Project/jquery/repeater.js"></script>
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
	<b><h3>อัพเดทสถานะการผลิต</h3></b>
	<form id="myForm" id="repeater_form" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">อัพเดทสถานะการผลิต</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="manufac_id" placeholder="" value="<?php echo $select->manufac_id; ?>">
	  	</div>
	  </div>
	
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="manufac_status" style="font-family: Mitr" id="myForm">
	      	<option value="" disabled="disabled">เลือกสถานะ</option>
	      	<option value="กำลังผลิต" name="manufac_status" <?php if($select->manufac_status =='กำลังผลิต'){ echo "selected='selected'";}?>>กำลังผลิต</option>
	      	<option value="ผลิตเสร็จแล้ว" name="manufac_status" <?php if($select->manufac_status =='ผลิตเสร็จแล้ว'){ echo "selected='selected'";}?>>ผลิตเสร็จแล้ว</option>
  		</select>
	    </div>
	  </div>

	   <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="manufacupdate" value="" class="btn btn-primary btn-md" onclick="if(!confirm('เปลี่ยนสถานะ แน่ใจหรือไม่?')) { return false; }">อัพเดท</button>
	     </input>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
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
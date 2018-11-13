<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$maintn_id = $_GET['maintn_id'];    //getting id from url

	$sql = 'SELECT * FROM maintenance WHERE maintn_id=:maintn_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':maintn_id' => $maintn_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM staff";
$stmtstaff = $db->prepare($sql);
$stmtstaff->execute();  ///stmt = statement
$result = $stmtstaff->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit data Machine maintanance</title>
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
	<b><h3>แก้ไขข้อมูลการซ่อมบำรุงเครื่องจักร</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลการซ่อมบำรุงเครื่องจักร</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="maintn_id" placeholder="" value="<?php echo $select->maintn_id; ?>">
	  	</div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อเครื่องจักร :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="maintn_title" 
	      value="<?php echo $select->maintn_title; ?>" placeholder="ชื่อเครื่องจักร" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ซ่อม :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="maintn_date" placeholder="" value="<?php echo $select->maintn_date; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายการซ่อม :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="maintn_desc" placeholder="" value="" required><?php echo $select->maintn_desc; ?></textarea>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อผู้ซ่อม :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="maintn_name" placeholder="อีเมล์" value="<?php echo $select->maintn_name; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เบอร์โทร :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="maintn_phone" placeholder="เบอร์โทร" value="<?php echo $select->maintn_phone; ?>">
	    </div>
	  </div>


	  				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อพนักงาน :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="maintnstaff_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกรหัสพนักงาน</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['staff_id']; ?>" <?php if ($result == $rows['staff_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['staff_id']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="machineupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
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
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
?>


<!DOCTYPE html>
<html>
<head>
	<title>Edit Manufacture</title>
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
	<b><h3>แก้ไขข้อมูลการผลิต</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลการผลิต</h4></b>
		</div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">รหัสการผลิต :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="manufac_id" placeholder="" value="<?php echo $select->manufac_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ผลิต :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="manufac_date" placeholder="" value="<?php echo $select->manufac_date; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวนที่สั่งผลิต :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="manufac_ordered" placeholder="นามสกุล" value="<?php echo $select->manufac_ordered; ?>" required>
	    </div>
	  </div>

	 <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วัตถุดิบที่ใช้ :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="manufac_userow" placeholder="วัตถุดิบที่ใช้" required><?php echo $select->manufac_userow; ?></textarea>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เลขล็อต :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="manufac_lotnum" placeholder="เบอร์โทร" value="<?php echo $select->manufac_lotnum; ?>">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<a href="index.php?page=button"><button type="submit" name="manufacupdate" value="" class="btn btn-primary btn-md">อัพเดท</button></a>
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
<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$pmodel_id = $_GET['pmodel_id'];    //getting id from url
$dir="../imgUpload/";
	$sql = 'SELECT * FROM productmodel WHERE pmodel_id=:pmodel_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':pmodel_id' => $pmodel_id]);
		$stmt->bindParam(":pmodel_img", $pmodel_img, PDO::PARAM_STR);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

?>


<!DOCTYPE html>
<html>
<head>
	<title>Edit data Product Model</title>
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
	<b><h3>แก้ไขข้อมูลแบบผลิตภัฑ์</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post" target="blank" enctype="multipart/form-data">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลแบบผลิตภัณฑ์</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="pmodel_id" placeholder="" value="<?php echo $select->pmodel_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อแบบผลิตภัณฑ์ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="pmodel_name" placeholder="ชื่อลูกค้า" value="<?php echo $select->pmodel_name; ?>" required>
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="pmodel_desc" placeholder="ที่อยู่" value="" required><?php echo $select->pmodel_desc; ?></textarea>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รูปภาพ :</label>
	    <div class="col-sm-10">
	      <div class="custom-file">
			  <input type="file" class="custom-file-input" name="pmodel_img" id="input" value="<?php echo $select->pmodel_img; ?>" accept="image/*"><?php echo $select->pmodel_img; ?>
			  <label class="custom-file-label" for="customFile" id="input">เลือกไฟล์</label>
			</div>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="pmodelupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
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
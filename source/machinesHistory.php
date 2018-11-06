<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;


$sql = "SELECT * FROM maintenance";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit machine history</title>
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
	<b><h3>เพิ่มประวัติการซ่อม</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">บันทึกประวัติการซ่อม</h4></b>
		</div>
		 <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="mch_id" placeholder="" value="">
	  	</div>
	  </div>
	 
	  				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อเครื่องจักร :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="maintn_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกชื่อเครื่องจักร</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['maintn_id']; ?>" <?php if ($result == $rows['maintn_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['maintn_id'].'.'.$rows['maintn_title']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ซ่อม :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="mch_date" placeholder="" value=" " required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="mch_desc" placeholder="" value="" required></textarea>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อผู้ซ่อม :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="mch_title" placeholder="อีเมล์" 
	      value=" " required>
	    </div>
	  </div>
	  

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="maintn_History" value="" class="btn btn-primary btn-md">บันทึก</button>
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
  <?include("../Project/database/insert.php");?>
  	</div>
</div>
</body>
</html>
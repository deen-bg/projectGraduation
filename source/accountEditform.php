<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$account_id = $_GET['account_id'];    //getting id from url

	$sql = 'SELECT * FROM account WHERE account_id=:account_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':account_id' => $account_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit data Account</title>
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
	<b><h3>แก้ไขข้อมูลรายรับ-รายจ่าย</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลรายรับ-รายจ่าย</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="account_id" placeholder="รหัสลูกค้า" value="<?php echo $select->account_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="account_date" placeholder="ชื่อลูกค้า" value="<?php echo $select->account_date; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ปี :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="account_year" placeholder="นามสกุล" value="<?php echo $select->account_year; ?>" required>
	    </div>
	  </div>

		<div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="account_desc" placeholder="ที่อยู่" required><?php echo $select->account_desc; ?></textarea>
	    </div>
	  </div>

		 <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ประเภทรายการ :</label>
	    <div class="col-sm-10">
	      <select name="account_itemtype" class="custom-select" id="input" style="font-family: Mitr">
		    <option name="account_itemtype" value="รายรับ" <?php if($select->account_itemtype =='รายรับ'){ echo "selected='selected'";}?>>รายรับ</option>
		    <option name="account_itemtype" value="รายจ่าย" <?php if($select->account_itemtype =='รายจ่าย'){ echo "selected='selected'";}?>>รายจ่าย</option>
		}?>
  		</select>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ยอดรวม :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="account_total" placeholder="เบอร์โทร" value="<?php echo $select->account_total; ?>">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="accountupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
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
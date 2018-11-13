<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$sell_id = $_GET['sell_id'];    //getting id from url

	$sql = 'SELECT * FROM sell WHERE sell_id=:sell_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':sell_id' => $sell_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);
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
	<b><h3>ข้อมูลการขาย</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">อัพเดทสถานะการจ่ายเงิน</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="sell_id" placeholder="" value="<?php echo $select->sell_id; ?>">
	  	</div>
	  </div>
	 
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะจ่ายเงิน :</label>
	    <div class="col-sm-10">
	      <select name="sell_status" class="custom-select" id="input" style="font-family: Mitr">
		    <option name="sell_status" value="จองแล้ว" <?php if($select->sell_status =='จองแล้ว'){ echo "selected='selected'";}?>>จองแล้ว</option>
		     <option name="sell_status" value="รอชำระเงิน" <?php if($select->sell_status =='รอชำระเงิน'){ echo "selected='selected'";}?>>รอชำระเงิน</option>
		     <option name="sell_status" value="ชำระเงินแล้ว" <?php if($select->sell_status =='ชำระเงินแล้ว'){ echo "selected='selected'";}?>>ชำระเงินแล้ว</option>
		}?>
  		</select>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<a href="index.php?page=button"><button type="submit" name="sellupdate" value="" class="btn btn-primary btn-md">อัพเดท</button></a>
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
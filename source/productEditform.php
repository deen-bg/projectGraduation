<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$product_id = $_GET['product_id'];    //getting id from url

	$sql = 'SELECT * FROM product WHERE product_id=:product_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':product_id' => $product_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

//////////////////Select product type table//////////////////////////
$sql = "SELECT * FROM producttype";
$stmtpdtype = $db->prepare($sql);
$stmtpdtype->execute();		//execute statatement
$result = $stmtpdtype->fetchAll(PDO::FETCH_ASSOC);
//////////////////END//////////////////////////////////////////////
/////////////////////Select table manufacture////////////////
$sql = "SELECT manufacture.*, product.product_name 
 FROM manufacture 
 INNER JOIN product ON manufacture.manufac_pfid = product.product_id 
 ORDER BY manufacture.manufac_id";
$stmtmanufac = $db->prepare($sql);
$stmtmanufac->execute();  ///stmt = statement
$resultmanufac = $stmtmanufac->fetchAll(PDO::FETCH_ASSOC);
///////////////////END////////////////////////////////////
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Product</title>
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
	<b><h3>แก้ไขข้อมูลสินค้า</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลสินค้า</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="product_id" placeholder="" value="<?php echo $select->product_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อสินค้า :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="product_name" placeholder="" value="<?php echo $select->product_name; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ราคา :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="product_pricepd" placeholder="" value="<?php echo $select->product_price; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">บรรจุ/ชิ้น :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="product_amountpd" placeholder="" value="<?php echo $select->product_amount; ?>" required>
	    </div>
	  </div>

	   <!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="product_status" style="font-family: Mitr" id="myForm">
	      	<option name="product_status" value="ไม่ได้เลือก"
	      	 <?php if($select->product_status =='ไม่ได้เลือก'){ echo "selected='selected'";}?>>เลือกสถานะ</option>
	      	<option name="product_status" value="มีพร้อมส่ง" 
	      	<?php if($select->product_status =='มีพร้อมส่ง'){ echo "selected='selected'";}?>>มีพร้อมส่ง</option>
  		</select>
	    </div>
	  </div>
							<!--foreign key Producttype-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสประเภทสินค้า :</label>
	    <div class="col-sm-10">
	      <select class="custom-select" id="input" name="producttype_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="">เลือกประเภทสินค้า</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['producttype_id']; ?>" <?php if ($result == $rows['producttype_id']) { echo "selected='selected'";}?>>
	      		<?php echo $rows['producttype_id'].'.'.$rows['producttype_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
	  					<!--foreign key Manufacture-->
	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="productupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
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
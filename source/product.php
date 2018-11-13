<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
//////////////////////////Select table producttype//////////
$sql = "SELECT * FROM producttype";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
////////////////END//////////////////////////////////////
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
	<title>Product Form</title>
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
	<b><h3>ข้อมูลสินค้า</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php " method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลสินค้า</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="product_id" placeholder="รหัสลูกค้า">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อสินค้า :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="product_name" placeholder="ชื่อสินค้า" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ราคา :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="product_pricepd" placeholder="THB." required>
	    </div>
	  </div>
	
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">บรรจุ/ชิ้น :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="product_amountpd" placeholder="จำนวน/หน่วย" required>
	    </div>
	  </div>

	  <!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="product_status" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="ไม่ได้เลือก" selected>เลือกสถานะ</option>
	      	<option value="สินค้าใหม่">สินค้าใหม่</option>
  		</select>
	    </div>
	  </div>
	  
					<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ประเภทสินค้า :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="producttype_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกประเภทสินค้า</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['producttype_id']; ?>" <?php if ($result == $rows['producttype_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['producttype_id']. $rows['producttype_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->
					<!--foreign key Manufacture-->
	<!--<div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสการผลิต :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="manufac_fid" value=' ' style="font-family: Mitr" id="myForm">x
	      	<option value="ไม่ได้เลือก" name="manufac_fid" selected>เลือกรหัสการผลิต</option>
	    <?php foreach($resultmanufac as $rowmanufac ) {?>
	      	<option value="<?php echo $rowmanufac['manufac_id']; ?>" 
	      		<?php if ($resultmanufac == $rowmanufac['manufac_id']) { echo 'selected'; } ?>>
	      		<?php 
	      			echo $rowmanufac['manufac_id'].'.'.$rowmanufac['product_name'];
	      			if($rowmanufac['manufac_status'] =='กำลังผลิต')
	      				{ 
	      					echo $rowmanufac['manufac_status'];
	      				}
	      		?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>-->
						<!--END foreign key Manufacture-->
	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href=""><button type="submit" name="submitproduct" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <a href="index.php?page=product"><button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button></a>
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

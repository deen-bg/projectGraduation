<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
////////////////////////////select staff table//////////////
$sql = "SELECT * FROM staff";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
///////////////////////////select product table/////////
$sql = "SELECT * FROM product";
$stmtpd = $db->prepare($sql);
$stmtpd->execute();  ///stmt = statement
$resultpd = $stmtpd->fetchAll(PDO::FETCH_ASSOC);
///////////////////////////////select rawmaterial table//
$sql = "SELECT * FROM rawmaterial";
$stmtrMtr = $db->prepare($sql);
$stmtrMtr->execute();  ///stmt = statement
$resultrMtr = $stmtrMtr->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Manufacture Form</title>
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
	<b><h3>ข้อมูลการผลิต</h3></b>
	<form id="myForm" id="repeater_form" class="" name="blog post" action="../Project/database/insert.php"
	 method="post" enctype="multipart/form-data">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลการผลิต</h4></b>
		</div>

	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="manufac_id" placeholder="รหัสการผลิต">
	  	</div>
	  </div>

					<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สินค้าที่สั่งผลิต :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="manufac_pfid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกรหัสสินค้า</option>
	    <?php foreach($resultpd as $rows ) {?>
	      	<option value="<?php echo $rows['product_id']; ?>" <?php if ($resultpd == $rows['product_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['product_id'].'.'.$rows['product_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่สั่งผลิต :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="manufac_date" placeholder="วันที่สั่งผลิต " required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวนที่สั่งผลิต :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="manufac_ordered" placeholder="ตัวเลขเท่านั้น" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">เลขล็อตที่ผลิต :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="manufac_lotnum" placeholder="เลขล็อตที่ผลิต">
	    </div>
	  </div>

	  				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสพนักงาน :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="manufacstaff_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกรหัสพนักงาน/ชื่อพนักงาน</option>
	    <?php foreach($result as $rows ) {?>
	      	<option value="<?php echo $rows['staff_id']; ?>" <?php if ($result == $rows['staff_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['staff_id'].'.'. $rows['staff_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>

	  			<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="manufac_status" style="font-family: Mitr" id="myForm">
	      	<option value="" selected>เลือกสถานะ</option>
	      	<option value="กำลังผลิต" name="manufac_status">กำลังผลิต</option>
	      	<option value="ผลิตเสร็จแล้ว" name="manufac_status" disabled="disabled">ผลิตเสร็จแล้ว</option>
  		</select>
	    </div>
	  </div>
			<!------------------------------foreign key rawmaterial table----------------->
                    <div id="repeater">
                    	<div class="repeater-heading" align="right">
                    		<button type="button" class="btn btn-primary repeater-add-btn">+</button>
                    	</div>
                    	<div class="clearfix"></div>
                    	<div class="items" data-group="programming_languages">
                    		<div class="item-content" align="center">
                    			<div class="form-group row">
                    				<label for="" class="col-sm-2 col-form-label">รหัสวัตถุดิบ:</label>
                    				<div class="col-md-4">
                    					<select data-skip-name="true" data-name="manufac_rowfid[]" id="input" class="form-control">
                    						<option value="" selected>--เลือกรหัสวัตถุดิบ/ชื่อวัตถุดิบ--</option>
                    						<?php foreach($resultrMtr as $rowrMtr ) {?>
                    							<option value="<?php echo $rowrMtr['matr_id']; ?>" 
                    								<?php if ($resultrMtr == $rowrMtr['matr_id']){ 
                    									echo 'selected'; } ?>>
                    									<?php echo $rowrMtr['matr_id'].'.'. $rowrMtr['matr_name']; ?>
									      		</option>
									    	<?php } ?>
                    					</select>
                                   	</div>
                                   	<label for="" class="col-xs-4 col-form-label">ปริมาณ :</label>
                                   	<div class="form-group col-md-3">
                                   		<input type="text" data-skip-name="true" class="form-control" 
                                   		data-name="manufac_QtyrMtr[]" id="input" placeholder="จำนวน/หน่วย">
                                   	</div>&nbsp;&nbsp;&nbsp;
                                   	<div class="form-group row">
                                   		<button id="remove-btn" onclick="$(this).parents('.items').remove()" 
                                   		class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
	                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="form-group col" align="right">
                    	<div class="col-sm-3">
                    		<div class="btn-group">
                    			<a href="#">
                    				<button type="submit" name="manufacsubmit" value="" class="btn btn-primary btn-md">บันทึก</button>
                    			</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    			<a href="index.php?page=customer">
                    				<button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
                    			</a>
                    		</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
<<!------------------------------END foreign key rawmaterial table----------------->
</form>
<div id="showdata">
    <?include("../Project/database/insert.php");?>
  </div>
</div>
<!-----------------script Add Remove Dynamic -------------------------------->
<script>
    $(document).ready(function()
    {
    	$('#repeater').createRepeater();
    	// เมื่อฟอร์มการเรียกใช้ evnet submit ข้อมูล 
        $('#repeater_form').on('submit', function(event)
        {
        	event.preventDefault();// ปิดการใช้งาน submit ปกติ เพื่อใช้งานผ่าน ajax
        	$.ajax(
        	{
        		url:"../database/insert.php",// ส่งค่าแบบ POST ไปยังไฟล์ insert.php
                method:"POST",
                data:$(this).serialize(),// เตรียมข้อมูล form สำหรับส่ง
                success:function(data)
                {
                    $('#repeater_form')[0].reset();
                    $('#repeater').createRepeater();
                    $('#success_result').html(data);
                }
            })
        });
    });
    </script>
<!-----------------END script Add Remove Dynamic -------------------------------->
</body>
</html>

<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;

$sql = "SELECT * FROM customer";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//"SELECT sell.*,

/*$sql = "SELECT * FROM product WHERE NOT product_status='สินค้าใหม่'";*/

$sql = "SELECT product.*, manufacture.manufac_pfid, manufacture.manufac_status
FROM product 
INNER JOIN manufacture ON manufacture.manufac_pfid = product.product_id 
WHERE NOT product_status='สินค้าใหม่' AND NOT manufac_status='กำลังผลิต'";
$stmtpd = $db->prepare($sql);
$stmtpd->execute();  ///stmt = statement
$resultpd = $stmtpd->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Selling Form</title>
	  <link rel="stylesheet" type="text/css" href="/Project/CSS/form.css"><!--form used-->
	  <script type="text/javascript" src="/Project/jquery/repeater.js"></script>
<!--no refresh page when submit!-->
<script type="text/javascript">
  $(document).ready(function() {
    $('#myForm').ajaxForm({
      target: '#showdata',
      success: function() {
        $('#showdata').fadeIn('slow');
      }
    });
  });
  </script>
<!--end-->
<style type="text/css">
    #test{
        text-align: right;
        float: right;
        align-items: right;
        justify-content: right;
        color: red;
    }
</style>
</head>
<body>
<!--Content!-->
<div class="main">
	<b><h3>ข้อมูลการขาย</h3></b>
	<form id="myForm" id="repeater_form" class="" name="blog post" action="../Project/database/insert.php" method="post" enctype="multipart/form-data">
		 <div class="form-group row">
			<b><h4 id="fh4">เพิ่มข้อมูลการขาย</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="sell_id" placeholder="รหัสการขาย">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ขาย :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="sell_date" placeholder="วันที่ขาย" required>
	    </div>
	  </div>

	 				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสลูกค้า :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="cus_fid" value=' ' style="font-family: Mitr" id="myForm" required>
	      	<option value="" selected>เลือกรหัสลูกค้า</option>
	    <?php foreach($result as $rows ) {?>
	      	<option required value="<?php echo $rows['cus_id']; ?>" <?php if ($result == $rows['cus_id']) { echo 'selected'; } ?>>
	      		<?php echo $rows['cus_id'].'.'.$rows['cus_name']; ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
					<!--END foreign key product type-->
<!------------------------------foreign key rawmaterial table----------------->
		<div id="repeater">
			<div class="repeater-heading" align="right">
				<button type="button" class="btn btn-primary repeater-add-btn">+</button>
			</div><div class="clearfix"></div>
			<div class="items" data-group="programming_languages">
				<div class="item-content" align="center">
					<div class="form-group row">
						<label for="" class="col-sm-2 col-form-label">ชื่อสินค้า:</label>
						<div class="col-sm-4">
							<select data-skip-name="true" data-name="pd_fid[]" id="input" class="form-control" 
							id="myForm" required>
							<option value="" selected>--เลือกชื่อสินค้า--</option>
							<?php foreach($resultpd as $rowpd ) {?>
								<option required value="<?php echo $rowpd['product_id']; ?>" 
									<?php if ($resultpd == $rowpd['product_id']) { echo 'selected'; } ?>>
									<?php echo $rowpd['product_name'].
                                    '&nbsp;&nbsp;&nbsp;<b id="test">ราคา:</b>&nbsp;'.$rowpd['product_price']; ?>
								</option>
							<?php } ?>
                    		</select>
                    	</div>
                    	<!--Auto multiply-->
                    	<script type="text/javascript">
                    		$(function () 
                    		{
                    			$("#price, #Qty").keyup(function ()
                    			{
                    				$("#total").val(+$("#price").val() * +$("#Qty").val());
                    			});
                    		});
                    	</script>
                    	<!-- <label for="" class="col-xs-2 col-form-label">ราคา :</label>
                    	<div class="form-group col-md-4">
                    		<input type="number" value="" id="price" data-skip-name="true" class="form-control" data-name="sell_price[]" placeholder="THB." autocomplete="off" required>
                    	</div> -->
                    	<label for="" class="col-xs-2 col-form-label">จำนวน :</label>
                    	<div class="form-group col-md-3">
                    		<input type="number" value="" id="Qty" data-skip-name="true" 
                    		class="form-control" data-name="sell_amount[]" placeholder="ตัวเลขเท่านั้น(THB.)" autocomplete="off" required>
                    	</div>
                    	<!-- <label for="" class="col-xs-2 col-form-label">ยอดรวม :</label>
                    	<div class="form-group col-sm-3">
                    		<input type="number" id="total" data-skip-name="true" 
                    		class="form-control" data-name="sell_total[]" 
                    		placeholder="THB." autocomplete="off" required>
                    	</div> -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
        <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	    	<select class="form-control" id="input" name="sell_status" style="font-family: Mitr" id="myForm">
	    		<option value="ไม่ได้เลือก">เลือกสถานะ</option>
	      		<option value="จองแล้ว" >จองแล้ว</option>
	      		<option value="รอชำระเงิน" >รอชำระเงิน</option>
	      		<option value="ชำระเงินแล้ว" >ชำระเงินแล้ว</option>
  			</select>
	    </div>
	</div>
	<br>
	<br>
    <br>
    <div class="form-group col" align="right">
    	<div class="col-sm-3">
    		<div class="btn-group"><a href="#"><button type="submit" name="sellsubmit" 
    			class="btn btn-primary btn-md">บันทึก</button></a>
    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<a href="index.php?page=sell"><button type="button" name="cancle" 
    				class="btn btn-secondary btn-md" >ยกเลิก</button></a>
    			</div>
    		</div>
    	</div>
    </div>
</div>
</div>

</form>
<br>
<br>
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

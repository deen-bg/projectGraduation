<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

////////////////////////////////////////Search///////////////////////////////////////////////
$search= '';      //Search//
if (isset($_POST['varsearch'])) 
{
  $varsearch = $_POST['varsearch'];
  $search = " WHERE `cus_name` LIKE '%$varsearch%' OR `product_name` LIKE '%$varsearch%' ";
}
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////select sell table/////////////////
$sql = "SELECT delivery.*,desc_sell.sell_fid, staff.staff_id, staff.staff_name, sell.sell_id, sell.cus_fid, customer.cus_name, product.product_name 
FROM delivery 
INNER JOIN desc_sell ON delivery.deliver_sellid = desc_sell.sell_fid
INNER JOIN sell ON delivery.deliver_sellid = sell.sell_id
INNER JOIN customer ON sell.cus_fid = customer.cus_id
INNER JOIN staff ON delivery.deliver_stafffid = staff.staff_id 
INNER JOIN product ON desc_sell.product_fid = product.product_id 
$search  
ORDER BY delivery.deliver_id";
////////////////////////////////////////////////////////////////sell.pd_fid
//$sql = "SELECT * FROM delivery";

$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute(); 
		
/*    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":deliver_id", $deliver_id, PDO::PARAM_INT);
$stmt->bindParam(":deliver_date", $deliver_date, PDO::PARAM_STR);
$stmt->bindParam(":deliver_by", $deliver_by, PDO::PARAM_STR);
$stmt->bindParam(":deliver_sellid", $deliver_sellid, PDO::PARAM_STR); 
$stmt->bindParam(":deliver_stafffid", $deliver_stafffid, PDO::PARAM_STR);
$stmt->bindParam(":deliver_status", $deliver_status, PDO::PARAM_STR);

$result = $stmt->execute(array(':deliver_id'=>$deliver_id, 
	':deliver_date'=>$deliver_date, 
	':deliver_by'=>$deliver_by)); //5*/

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Delivery</title>
</head>
  <body>
  	<div class="main">
  		<b><h3>ข้อมูลการจัดส่งสินค้า</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
    <form class="form-inline" action="index.php?page=delivery" method="post" >
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยชื่อลูกค้า/ชื่อสินค้า" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href="index.php?page=deliver_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;
			<a href="index.php?page=addnewDelivery"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูลการจัดส่ง
			</button></a>
	  	</div>
	</div>
</div>
  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
      <!--    <th>Pk</th> <!--Pk-->
          <th>รหัสการขาย</th><!--Fk-->
         <!-- <th>pkขาย</th>-->
        <!--  <th>รหัสลูกค้า</th>-->
          <th>ชื่อลูกค้า</th>
          <th>ชื่อสินค้า</th>
          <th>วันที่จัดส่ง</th>
          <th>จัดส่งโดย</th>
          <th>ชื่อพนักงาน</th>
          <th>สถานะจัดส่ง</th>
          <th>จัดการข้อมูล
          <button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i>ลบที่เลือก</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>

        </tr>
      </thead>
      <tbody>
        <?php
       
         while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->sell_fid ?></td>
          <td><?php echo $row->cus_name ?></td>
          <td><?php echo $row->product_name ?></td>
          <td><?php echo $row->deliver_date ?></td>
          <td><?php echo $row->deliver_by ?></td>
          <td><?php echo $row->staff_name ?></td>
          <td><?php echo $row->deliver_status ?></td>
          <td>
              <a href="index.php?page=deliveryEditform&deliver_id=<?= $row->deliver_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=deliverEditform&deliver_id=<?= $row->deliver_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>
              <input class="checkbox" type="checkbox" id="<?php echo $row->deliver_id; ?>" name="id[]"></td>
        </tr>
        <?php }  ?>
      </tbody>
    </table>
</div>
</div>
<!--------Delete multiple records using checkbox in PHP and MySQL without refreshing page------>
<script>
  $(document).ready(function(){
      $('#checkAll').click(function(){
         if(this.checked){
             $('.checkbox').each(function(){
                this.checked = true;
             });   
         }else{
            $('.checkbox').each(function(){
                this.checked = false;
             });
         } 
      });
    $('#delete').click(function(){
       var dataArr  = new Array();
       if($('input:checkbox:checked').length > 0){
          $('input:checkbox:checked').each(function(){
              dataArr.push($(this).attr('id'));
              $(this).closest('tr').remove();
          });
          sendResponse(dataArr)
       }else{
         alert('กรุณาเลือกถูกในช่อง [/] ก่อน! ');
       }
    });
    function sendResponse(dataArr){
        $.ajax({
            type    : 'post',
            url     : './source/edit.php',
            data    : {'datadeliver' : dataArr},
            success : function(response){
                        alert(response);
                      },
            error   : function(errResponse){
                      alert(errResponse);
                      }
        });
    }
  });
</script>
<!--------Delete multiple records using checkbox in PHP and MySQL without refreshing page------>
  </body>
</html>
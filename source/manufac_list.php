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
  $search = " AND `manufac_status` LIKE '%$varsearch%' ";
}
/////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT manufacture.*, staff.staff_id, staff.staff_name, product.product_id, product.product_name
FROM manufacture 
INNER JOIN staff ON manufacture.manufacstaff_fid = staff.staff_id 
INNER JOIN product ON manufacture.manufac_pfid = product.product_id 
WHERE NOT manufac_status='ยกเลิก' $search 
ORDER BY manufacture.manufac_status ASC";

$stmt = $db->prepare($sql);//prepare data after select//
		
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":manufac_id", $manufac_id, PDO::PARAM_INT);
$stmt->bindParam(":manufac_date", $manufac_date, PDO::PARAM_STR);
$stmt->bindParam(":manufac_ordered", $manufac_ordered, PDO::PARAM_STR);
$stmt->bindParam(":manufac_userow", $manufac_userow, PDO::PARAM_STR);
$stmt->bindParam(":manufac_lotnum", $manufac_lotnum, PDO::PARAM_STR);
$stmt->bindParam(":manufac_status", $manufac_status, PDO::PARAM_STR);

$result = $stmt->execute(array(':manufac_id'=>$manufac_id, 
	':manufac_date'=>$manufac_date, ':manufac_ordered'=>$manufac_ordered, 
	':manufac_userow'=>$manufac_userow, ':manufac_lotnum'=>$manufac_lotnum, ':manufac_status'=>$manufac_status)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show Manufacture</title>
</head>
  <body>
<div class="main">
  		<b><h3>ข้อมูลการผลิต</h3></b>
  		<br>
  		<br>
<div class="row">
	 <div class="col-8">
    <form class="form-inline" action="index.php?page=manufacture" method="post" >
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยสถานะผลิต" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;
			<a href="index.php?page=addnewrowManufac"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่มข้อมูลการผลิต
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
         <!--  <th>รหัสการผลิต</th> -->
          <th>ชื่อพนักงาน</th>
          <th>วันที่ผลิต</th>
          <th>สินค้าที่ผลิต</th>
         <th>จำนวนที่สั่งผลิต</th>
         <th>สถานะ</th>
       <!--   <th>เลขล็อต</th>-->
          <th>จัดการข้อมูล&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <!-- <td><?php echo $row->manufac_id ?></td> -->
          <td><?php echo $row->staff_name ?></td>
          <td><?php echo $row->manufac_date ?></td>
          <td><?php echo $row->product_id.'.'.$row->product_name ?></td>
          <td><?php echo $row->manufac_ordered ?></td>
          <td><?php
          if ($row->manufac_status == 'ผลิตเสร็จแล้ว') 
          {
             echo $row->manufac_status;
          }
          else
          {
            echo $row->manufac_status?>
            <a href="index.php?page=manufacEditform&manufac_id=<?= $row->manufac_id; ?>"><button name="view"class="btn btn-outline-warning btn-sm" onclick="if(!confirm('ต้องการอัพเดทสถานะ ใช่หรือไม่?')) { return false; }" style="width:auto;"><i class="fa fa-cog" aria-hidden="true"></i></button></a>
    <?php } ?>
          </td>
        <td> <a href="index.php?page=manufacDesc&manufac_id=<?= $row->manufac_id; ?>" style="text-decoration:none"><button class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a> |
          <?php 
            if ($row->manufac_status == 'ผลิตเสร็จแล้ว') 
            { ?>
                <button class="btn btn-secondary" disabled="disabled">
                  <i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;เสร็จสิ้น</button>
           <?php }  
            else{ ?>
               <a href="./source/edit.php?page=manufacEditform&Cancle_manufac=<?= $row->manufac_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-secondary"><i class="fa fa-times" aria-hidden="true" onclick="if(!confirm('คุณต้องการยกเลิกการผลิต แน่ใจหรือไม่?')) { return false; }"></i></i>&nbsp;ยกเลิก</a></button>
          <?php  } ?> &nbsp;&nbsp;|
              <!-- <a href="./source/edit.php?page=manufacEditform&manufac_id=<?= $row->manufac_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>--->
              <input class="checkbox" type="checkbox" id="<?php echo $row->manufac_id; ?>" name="id[]">
            </td> 
        </tr>
        <?php } ?>
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
            data    : {'datamanufac' : dataArr},
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

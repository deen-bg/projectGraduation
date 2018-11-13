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
  $search = " AND `sell_status` LIKE '%$varsearch%' OR `sell_deliverStatus` LIKE '%$varsearch%' ";
}
/*/////////////////////////////////////////////////////////////////////////////////////////////
      //Select table customer for Serach//
$sql = "SELECT * FROM customer $search";
$stmt = $db->prepare($sql);
$stmt->execute();
////////////////////END/////////////////////////////////////////////////////////////////////////////*/

$sql = "SELECT sell.*, customer.cus_id, customer.cus_name 
FROM sell 
INNER JOIN customer ON sell.cus_fid = customer.cus_id 
WHERE NOT sell_status='ยกเลิก' $search 
ORDER BY sell.sell_status DESC";

$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute(); 
    ///convert column names from tables in database. is a php variable
/*$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);  //bind parameter = การแทนที่ตัวแปรใน statement เพื่อประมวลผลต่างๆ
$stmt->bindParam(":sell_date", $sell_date, PDO::PARAM_STR);
$stmt->bindParam(":sell_status", $sell_status, PDO::PARAM_STR);
$stmt->bindParam(":sell_deliverStatus", $sell_deliverStatus, PDO::PARAM_STR);

$result = $stmt->execute(array(':sell_id'=>$sell_id, ':sell_date'=>$sell_date, 
':sell_status'=>$sell_status, ':sell_deliverStatus'=>$sell_deliverStatus)); //5*/

?>
<!DOCTYPE html>
<html>
<head>
    <title>show Product</title>
</head>
  <body>
  	<div class="main">
  		<b><h3>ข้อมูลการขาย</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
    <form class="form-inline" action="index.php?page=sell" method="post" >
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยสถานะจ่าย/สถานะจัดส่ง" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href="index.php?page=sell_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;
			<a href="index.php?page=addnewrowSell" title="เพิ่มการสั่งซื้อ"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูลการขาย
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
         <!-- <th>รหัสการขาย</th>-->
        <!--   <th>รหัสลูกค้า</th> -->
          <th>ชื่อลูกค้า</th>
          <th>วันที่ขาย</th>
          <th>สถานะการจ่าย</th>
          <th>สถานะจัดส่ง</th>
          <th>จัดการข้อมูล<!-- &nbsp;&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger btn-sm" id="delete" title="ลบที่เลือก"><i class="fa fa-trash" aria-hidden="true"></i>ลบที่เลือก</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll" 
            title="เลือกทั้งหมด"> --></th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
        <!--   <td><?php echo $row->sell_id ?></td> -->
       <!--    <td><?php echo $row->cus_id ?></td> -->
          <td><?php echo $row->cus_name ?></td>
          <td><?php echo $row->sell_date ?></td>
          <td>
            <?php
            if ($row->sell_status =='ชำระเงินแล้ว')
            {
              echo $row->sell_status;
            }
            else
            {
               echo $row->sell_status ?>
            <a href="index.php?page=sellEditform&sell_id=<?= $row->sell_id; ?>" title="กดเปลี่ยนสถานะจ่ายเงิน"><button name="view"class="btn btn-outline-warning btn-sm" onclick="if(!confirm('ต้องการอัพเดทสถานะการจ่ายเงิน ใช่หรือไม่?')) { return false; }" style="width:auto;"><i class="fa fa-cog" aria-hidden="true"></i></button></a>

           <?php } ?>
          </td>
          <td><?php
          if ($row->sell_deliverStatus != NULL) 
          {
            echo "<b style='color: green;'>".$row->sell_deliverStatus;
          }
          else{
            echo "<i style='color: orange;'>รอดำเนินการ</i>";
          }

            ?></td>
          <td><a href="index.php?page=sellDesc&sell_id=<?= $row->sell_id; ?>" title="กดดูรายละเอียด" style="text-decoration:none"><button class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a> |
            <?php 
            if ($row->sell_status =='ชำระเงินแล้ว') 
            { ?>
                <button class="btn btn-secondary" disabled="disabled">
                  <i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;เสร็จสิ้น</button>
           <?php }  
            else{ ?>
                 <a href="./source/edit.php?page=sellEditform&sell_Cancle=<?= $row->sell_id; ?>" style="text-decoration:none color: #ffffff;" title="ยกเลิกการขาย"><button class="btn btn-secondary"><i class="fa fa-times" aria-hidden="true" onclick="if(!confirm('คุณต้องการยกเลิกการผลิต แน่ใจหรือไม่?')) { return false; }"></i>&nbsp;ยกเลิก</button></a>&nbsp;
          <?php  } ?>

             |&nbsp;
              <!-- <a href="./source/edit.php?page=sellEditform&sell_id=<?= $row->sell_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a> -->
               <!--  <input class="checkbox" type="checkbox" id="<?php echo $row->sell_id; ?>" name="id[]" 
                 title="คลิกเพื่อลบ"> -->
              </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
   <br/>
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
            data    : {'data' : dataArr},
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

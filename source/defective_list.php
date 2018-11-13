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
  $search = " WHERE `product_name` LIKE '%$varsearch%'";
}
/////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT defective.*, product.product_id, product.product_name 
FROM defective 
INNER JOIN product ON defective.pddefective_fid = product.product_id 
$search
ORDER BY defective.defective_id";
//$sql = "SELECT * FROM defective";
$stmt = $db->prepare($sql);
$stmt->execute();  ////execute statatement

/*    ///bind variable from customer table  to variable in php
$stmt->bindParam(":defective_id", $defective_id, PDO::PARAM_INT);
$stmt->bindParam(":defective_date", $defective_date, PDO::PARAM_INT);
$stmt->bindParam(":defective_amount", $defective_amount, PDO::PARAM_STR);
$stmt->bindParam(":defective_total", $defective_total, PDO::PARAM_STR);
$result = $stmt->execute(array(':defective_id'=>$defective_id, 
  ':defective_amount'=>$defective_amount, ':defective_total'=>$defective_total)); //5*/

?>
<!DOCTYPE html>
<html>
<head>
    <title>show defective product</title>
</head>
  <body>
    <div class="main">
      <br>
      <br>
      <b><h3>ข้อมูลสินค้าชำรุด</h3></b>
      <br>
      <br>
<div class="row">
  <div class="col-8">
    <form class="form-inline" action="index.php?page=defective" method="post" >
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยชื่อสินค้า" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
  <div class="col-sm-4" align="right">
    <div class="btn-group">
      <a href="index.php?page=defective_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;
      <a href="index.php?page=addnewDefective"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่มข้อมูลใหม่
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
           <th>วันที่</th>
          <th>รหัสสินค้า</th>
          <th>จำนวน</th>
          <th>ค่าเสียหาย(THB.)</th>
          <th>จัดการข้อมูล
          <button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->defective_date ?></td>
          <td><?php echo $row->product_id.'.'.$row->product_name ?></td>
          <td><?php echo $row->defective_amount ?></td>
          <td><?php echo $row->defective_total ?></td>
          <td>
              <a href="index.php?page=defectiveEditform&defective_id=<?= $row->defective_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=defectiveEditform&defective_id=<?= $row->defective_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>
              <input class="checkbox" type="checkbox" id="<?php echo $row->defective_id; ?>" name="id[]"></td>
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
            data    : {'datapdDefec' : dataArr},
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

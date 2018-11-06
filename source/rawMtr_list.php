<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;
//////////////////////////////////search////////////////////////////////////////
if(isset($_POST['searchkey'])){
  $searchkey= $_POST['searchkey'];
  echo $searchkey;
  $stmt = $db->prepare("SELECT * FROM rawmaterial WHERE matr_name LIKE '%$searchkey%' ORDER BY rand() LIMIT 0,10");
  $stmt->bindValue(1, "%$searchkey%", PDO::PARAM_STR);
  $stmt->execute();
  if (!$stmt->rowCount() == 0)
  {
    while ($row = $stmt->fetch())
    {
      echo $row['matr_name'];
    }
  }
}
/////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM rawmaterial";
//$sql = "SELECT * FROM rawmaterial";
$stmt = $db->prepare($sql);

    ///bind variable from customer table  to variable in php
$stmt->bindParam(":matr_id", $matr_id, PDO::PARAM_INT);
$stmt->bindParam(":matr_name", $matr_name, PDO::PARAM_STR);
$stmt->bindParam(":matr_impdate", $matr_impdate, PDO::PARAM_STR);
$stmt->bindParam(":matr_quantity", $matr_quantity, PDO::PARAM_STR);
$stmt->bindParam(":matr_price", $matr_price, PDO::PARAM_STR);

$stmt->execute();  //execute statatement
$result = $stmt->execute(array(':matr_id'=>$matr_id, 
	':matr_name'=>$matr_name, ':matr_impdate'=>$matr_impdate, 
	':matr_quantity'=>$matr_quantity, ':matr_price'=>$matr_price)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Row material</title>
</head>
  <body>
  	<div class="main">
  		<b><h3>ข้อมูลวัตถุดิบ</h3></b>
  		<br>
  		<br>

<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=material" method="post" >
		    <input class="form-control" type="text" name="searchkey" value="" placeholder="ค้นหาด้วยชื่อ" 
        aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  	</form>
	</div>

	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href="index.php?page=rawMtr_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewrowMaterial"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มวัตถุดิบ
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
       <th>รหัสวัตถุดิบ</th>
          <th>ชื่อวัตถุดิบ</th>
          <th>วันที่นำเข้า</th>
          <th>ปริมาณ</th>
          <th>ราคา/หน่วย</th>
          <th>จัดการข้อมูล</th>
          <th><button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->matr_id ?></td>
          <td><?php echo $row->matr_name ?></td>
          <td><?php echo $row->matr_impdate ?></td>
          <td><?php 
          if($row->matr_quantity > 0)
          {
            echo $row->matr_quantity;
          }
          else
          {
            echo '<i style="background-color:red;">วัตถุดิบหมด</i>';
          }
          ?></td>
          <td><?php echo $row->matr_price ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
              <a href="index.php?page=rawEditform&matr_id=<?= $row->matr_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=rawEditform&matr_id=<?= $row->matr_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
               <td><input class="checkbox" type="checkbox" id="<?php echo $row->matr_id; ?>" name="id[]"></td>
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
            data    : {'datarows' : dataArr},
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
  </body>
</html>

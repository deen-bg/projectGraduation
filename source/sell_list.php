<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM sell WHERE sell_date LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT sell.*, customer.cus_id, customer.cus_name 
FROM sell 
INNER JOIN customer ON sell.cus_fid = customer.cus_id 
ORDER BY sell.sell_id";

$stmt = $db->prepare($sql);//prepare data after select//
		
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);  //bind parameter = การแทนที่ตัวแปรใน statement เพื่อประมวลผลต่างๆ
$stmt->bindParam(":sell_date", $sell_date, PDO::PARAM_STR);
$stmt->bindParam(":sell_status", $sell_status, PDO::PARAM_STR);

$result = $stmt->execute(array(':sell_id'=>$sell_id, 
	':sell_date'=>$sell_date, ':sell_status'=>$sell_status)); //5

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
		    <input class="form-control" type="date" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยวันที่ขาย" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewrowSell"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูลการขาย
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
          <th>รหัสการขาย</th>
          <th>รหัสลูกค้า</th>
          <th>ชื่อลูกค้า</th>
          <th>วันที่ขาย</th>
          <th>สถานะ</th>
          <th>จัดการข้อมูล</th>
          <th><button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->sell_id ?></td>
          <td><?php echo $row->cus_id ?></td>
          <td><?php echo $row->cus_name ?></td>
          <td><?php echo $row->sell_date ?></td>
          <td><?php echo $row->sell_status ?></td>
          <td><a href="index.php?page=sellDesc&sell_id=<?= $row->sell_id; ?>" style="text-decoration:none"><button class="btn btn-secondary"><i class="fa fa-eye" aria-hidden="true"></i></button></a> |
              <a href="index.php?page=sellEditform&sell_id=<?= $row->sell_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=sellEditform&sell_id=<?= $row->sell_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>
                <td><input class="checkbox" type="checkbox" id="<?php echo $row->sell_id; ?>" name="id[]"></td>
              </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
   <br/>
  <!--<button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
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

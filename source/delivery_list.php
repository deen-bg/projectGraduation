<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM delivery WHERE deliver_id LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();
/////////////////////////////////////////////////////////////////
/////////////////select sell table/////////////////
$sql = "SELECT delivery.*,desc_sell.sell_fid, staff.staff_id, staff.staff_name, sell.sell_id 
FROM delivery 
INNER JOIN desc_sell ON delivery.deliver_sellid = desc_sell.sell_fid
INNER JOIN sell ON delivery.deliver_sellid = sell.sell_id
INNER JOIN staff ON delivery.deliver_stafffid = staff.staff_id 
ORDER BY delivery.deliver_id";
////////////////////////////////////////////////////////////////sell.pd_fid
//$sql = "SELECT * FROM delivery";

$stmt = $db->prepare($sql);//prepare data after select//
		
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":deliver_id", $deliver_id, PDO::PARAM_INT);
$stmt->bindParam(":deliver_date", $deliver_date, PDO::PARAM_STR);
$stmt->bindParam(":deliver_by", $deliver_by, PDO::PARAM_STR);
$stmt->bindParam(":deliver_sellid", $deliver_sellid, PDO::PARAM_STR); 
$stmt->bindParam(":deliver_stafffid", $deliver_stafffid, PDO::PARAM_STR); 

$result = $stmt->execute(array(':deliver_id'=>$deliver_id, 
	':deliver_date'=>$deliver_date, 
	':deliver_by'=>$deliver_by)); //5

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
		<form class="form-inline" action="../Project/source/cus_list.php" method="get" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสวัตถุดิบ" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
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
          <th>Pk</th>
          <th>รหัสการขาย</th>
          <th>pkขาย</th>
          <th>วันที่</th>
          <th>จัดส่งโดย</th>
          <th>รหัสพนักงาน</th>
          <th>จัดการ</th>

        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->deliver_id ?></td>
          <td><?php echo $row->sell_fid ?></td>
          <td><?php echo $row->sell_id ?></td>
          <td><?php echo $row->deliver_date ?></td>
          <td><?php echo $row->deliver_by ?></td>
          <td><?php echo $row->staff_id ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
              <a href="index.php?page=deliveryEditform&deliver_id=<?= $row->deliver_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=deliverEditform&deliver_id=<?= $row->deliver_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

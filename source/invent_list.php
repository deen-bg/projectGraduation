<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM inventory WHERE invent_id LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT * FROM inventory";

$stmt = $db->prepare($sql); //prepare data after select//
		
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":invent_id", $invent_id, PDO::PARAM_INT);
$stmt->bindParam(":invent_date", $invent_date, PDO::PARAM_STR);
$stmt->bindParam(":invent_amount", $invent_amount, PDO::PARAM_STR);
$stmt->bindParam(":invent_price", $invent_price, PDO::PARAM_STR);
$stmt->bindParam(":invent_status", $invent_status, PDO::PARAM_STR);

$result = $stmt->execute(array(':invent_id'=>$invent_id, 
	':invent_date'=>$invent_date, ':invent_amount'=>$invent_amount, 
	':invent_price'=>$invent_price, ':invent_status'=>$invent_status)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Wharehouse</title>
</head>
  <body>
  	<div class="main">
  		<b><h3>ข้อมูลสินค้าในคลัง</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=inventory" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสวัตถุดิบ" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewrowInventory"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md">เพิ่มสินค้าในคลัง
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
          <th>วันที่นำสินค้าเข้าคลัง</th>
          <th>สินค้าคงเหลือ</th>
          <th>ราคาต่อหน่วย</th>
          <th>สถานะ</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->invent_date ?></td>
          <td><?php echo $row->invent_amount ?></td>
          <td><?php echo $row->invent_price ?></td>
          <td><?php echo $row->invent_status ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
            <a href="index.php?page=inventEditform&invent_id=<?= $row->invent_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=inventEditform&invent_id=<?= $row->invent_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>
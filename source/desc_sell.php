<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM desc_sell WHERE descsell_id LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT desc_sell.*, product.product_id, sell.sell_id, sell.sell_amount
FROM desc_sell 
INNER JOIN product ON desc_sell.product_fid = product.product_id 
INNER JOIN sell ON desc_sell.sell_fid = sell.sell_id 
ORDER BY desc_sell.descsell_id";

$stmt = $db->prepare($sql);

   ///bind variable from customer table  to variable in php
$stmt->bindParam(":descsell_id", $descsell_id, PDO::PARAM_INT);
$stmt->execute();  ////execute statatement
$result = $stmt->execute(array(':descsell_id'=>$descsell_id));

?>
<!DOCTYPE html>
<html>
<head>
    <title>show Description selling</title>

</head>
  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลรายละเอียดการขาย</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="../Project/source/product_list.php" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสการขาย" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
      <a href="index.php?page=addnewdescsell"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูล
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
          <th>รหัสสินค้า</th>
          <th>รหัสการขาย</th>
          <th>จำนวนที่ขาย</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->product_id ?></td>
          <td><?php echo $row->sell_id ?></td>
          <td><?php echo $row->sell_amount ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
            <a href="index.php?page=descsellditForm&descsell_id=<?= $row->descsell_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=descsellditForm&descsell_id=<?= $row->descsell_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <br>
    <br>
    <br>
    <br>
</div>
</body>
</html>

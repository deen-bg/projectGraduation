<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM defective WHERE pddefective_fid LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT defective.*, product.product_id, product.product_name 
FROM defective 
INNER JOIN product ON defective.pddefective_fid = product.product_id 
ORDER BY defective.defective_id";
//$sql = "SELECT * FROM defective";
$stmt = $db->prepare($sql);

    ///bind variable from customer table  to variable in php
$stmt->bindParam(":defective_id", $defective_id, PDO::PARAM_INT);
$stmt->bindParam(":defective_amount", $defective_amount, PDO::PARAM_STR);
$stmt->bindParam(":defective_total", $defective_total, PDO::PARAM_STR);

$stmt->execute();      //execute statatement

$result = $stmt->execute(array(':defective_id'=>$defective_id, 
  ':defective_amount'=>$defective_amount, ':defective_total'=>$defective_total)); //5

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
        <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสสินค้า" aria-label="Search">&nbsp;
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
  <div class="col-sm-4" align="right">
    <div class="btn-group">
      <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
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
          <th>รหัสสินค้า</th>
          <th>จำนวน</th>
          <th>ค่าเสียหาย(THB.)</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->product_id.'.'.$row->product_name ?></td>
          <td><?php echo $row->defective_amount ?></td>
          <td><?php echo $row->defective_total ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
              <a href="index.php?page=defectiveEditform&defective_id=<?= $row->defective_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=defectiveEditform&defective_id=<?= $row->defective_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

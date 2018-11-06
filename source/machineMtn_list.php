<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM maintenance WHERE maintn_date LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT maintenance.*, staff.staff_id 
FROM maintenance 
INNER JOIN staff ON maintenance.maintnstaff_fid = staff.staff_id 
ORDER BY maintenance.maintn_id";
//$sql = "SELECT * FROM maintenance";
$stmt = $db->prepare($sql);
		
    ///bind variable from customer table  to variable in php
$stmt->bindParam(":maintn_id", $maintn_id , PDO::PARAM_INT);
$stmt->bindParam(":maintn_title", $maintn_title, PDO::PARAM_STR);
$stmt->bindParam(":maintn_date", $maintn_date, PDO::PARAM_STR);
$stmt->bindParam(":maintn_desc", $maintn_desc, PDO::PARAM_STR);
$stmt->bindParam(":maintn_name", $maintn_name, PDO::PARAM_STR);
$stmt->bindParam(":maintn_phone", $maintn_phone, PDO::PARAM_STR);

$stmt->execute();  //execute statatement

$result = $stmt->execute(array(':maintn_id'=>$maintn_id, ':maintn_title'=>$maintn_title,
	':maintn_date'=>$maintn_date, ':maintn_desc'=>$maintn_desc, 
	':maintn_name'=>$maintn_name, ':maintn_phone'=>$maintn_phone)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Machine maitenance</title>
</head>
  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลการซ่อมบำรุงเครื่องจักร</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=repairmachine" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสลูกค้า" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewmachineMaintenance"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่มข้อมูลใหม่
			</button></a>
      &nbsp;
      <a href="index.php?page=machineHistoryForm"><button class="btn btn-warning" type="submit" name="button" value="" ><i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;ซ่อม
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
          <th>PK</th>
          <th>รหัสพนักงาน</th>
          <th>ชื่อเครื่องจักร</th>
          <th>วันที่ซ่อม</th>
          <th>รายละเอียด</th>
          <th>ชื่อผู้ซ่อม</th>
          <th>เบอร์โทร</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->maintn_id ?></td>
          <td><?php echo $row->staff_id ?></td>
          <td><?php echo $row->maintn_title ?></td>
          <td><?php echo $row->maintn_date ?></td>
          <td><?php echo $row->maintn_desc ?></td>
          <td><?php echo $row->maintn_name ?></td>
          <td><?php echo $row->maintn_phone ?></td>
          <td> <a href="index.php?page=mch_DescHistory&maintn_id=<?= $row->maintn_id; ?>" style="text-decoration:none"><button class="btn btn-secondary"><i class="fa fa-eye" aria-hidden="true"></i></button></a> |&nbsp;
            <a href="index.php?page=machineMtneditForm&maintn_id=<?= $row->maintn_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</a></button> |
              <a href="./source/edit.php?page=machineMtneditForm&maintn_id=<?= $row->maintn_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

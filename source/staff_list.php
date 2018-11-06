<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$sql = "SELECT * FROM staff WHERE staff_name LIKE :search";
$stmt2 = $db->prepare($sql);
$stmt2->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_STR);
//$stmt2->bindParam(":staff_name", $staff_name, PDO::PARAM_STR);
$stmt2->execute();
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM staff";
$stmt = $db->prepare($sql);

    ///bind variable from customer table  to variable in php
$stmt->bindParam(":staff_id", $staff_id, PDO::PARAM_INT);
$stmt->bindParam(":staff_name", $staff_name, PDO::PARAM_STR);
$stmt->bindParam(":staff_surname", $staff_surname, PDO::PARAM_STR);
$stmt->bindParam(":staff_passportid", $staff_passportid, PDO::PARAM_STR);
$stmt->bindParam(":staff_add", $staff_add, PDO::PARAM_STR);
$stmt->bindParam(":staff_stwd", $staff_stwd, PDO::PARAM_STR);
$stmt->bindParam(":staff_phone", $staff_phone, PDO::PARAM_STR);

$stmt->execute();  //execute statatement

$result = $stmt->execute(array(':staff_id'=>$staff_id, 
	':staff_name'=>$staff_name, ':staff_surname'=>$staff_surname, 
	':staff_passportid'=>$staff_passportid, ':staff_add'=>$staff_add,
	':staff_stwd'=>$staff_stwd, ':staff_phone'=>$staff_phone)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Staff</title>
</head>

  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลพนักงาน</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=staff" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch; ?>" placeholder="ค้นหาด้วยชื่อลูกค้า" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="search">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href="index.php?page=staff_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewStaff"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูลพนักงาน</button></a>
	  	</div>
	</div>
</div>
  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
          <th>ชื่อพนักงาน</th>
          <th>นามสกุล</th>
          <th>เลขบัตรประชาชน</th>
          <th>ที่อยู่</th>
          <th>วันที่เริ่มทำงาน</th>
          <th>เบอร์โทร</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->staff_id.'.'.$row->staff_name ?></td>
          <td><?php echo $row->staff_surname ?></td>
          <td><?php echo $row->staff_passportid ?></td>
          <td><?php echo $row->staff_add ?></td>
          <td><?php echo $row->staff_stwd ?></td>
          <td><?php echo $row->staff_phone ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
              <a href="index.php?page=staffditForm&staff_id=<?= $row->staff_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=staffditForm&staff_id=<?= $row->staff_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

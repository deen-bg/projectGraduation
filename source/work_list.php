<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM work WHERE work_date LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT work.*, staff.staff_name, staff.staff_id 
FROM work 
INNER JOIN staff ON work.staff_fid = staff.staff_id ORDER BY work.work_id";
//$sql = "SELECT * FROM work";
$stmt = $db->prepare($sql);

    ///bind variable from customer table  to variable in php
$stmt->bindParam(":work_id", $work_id, PDO::PARAM_INT);
$stmt->bindParam(":work_date", $work_date, PDO::PARAM_STR);
$stmt->bindParam(":work_dayoff", $work_dayoff, PDO::PARAM_STR);
$stmt->bindParam(":work_time", $work_time, PDO::PARAM_STR);

$stmt->execute();  //execute statatement
$result = $stmt->execute(array(':work_id'=>$work_id, 
	':work_date'=>$work_date, ':work_dayoff'=>$work_dayoff, 
	':work_time'=>$work_time)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Row working</title>
</head>
  <body>
  	<div class="main">
  		<b><h3>ข้อมูลการทำงาน</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=work" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยวันที่" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href="index.php?page=work_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewwork"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่ม
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
           <th>รหัสพนักงาน</th>
          <th>วันที่ทำงาน</th>
          <th>จำนวนวันลางาน</th>
          <th>เวลาเข้างาน</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr >
          <td><?php echo $row->staff_id.'.'.$row->staff_name ?></td>
          <td><?php echo $row->work_date ?></td>
          <td><?php echo $row->work_dayoff ?></td>
          <td><?php echo $row->work_time ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
              <a href="index.php?page=workEditform&work_id=<?= $row->work_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=workEditform&work_id=<?= $row->work_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

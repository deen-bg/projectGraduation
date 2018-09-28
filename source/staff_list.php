<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM staff WHERE staff_name LIKE :search OR staff_surname LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();


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

		//execute statatement
$stmt->execute();  ///stmt = statement

$result = $stmt->execute(array(':staff_id'=>$staff_id, 
	':staff_name'=>$staff_name, ':staff_surname'=>$staff_surname, 
	':staff_passportid'=>$staff_passportid, ':staff_add'=>$staff_add,
	':staff_stwd'=>$staff_stwd, ':staff_phone'=>$staff_phone)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Staff</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  	<!--sidebar & navbar!-->
	<link rel="stylesheet" type="text/css" href="/Project/Menu/Menu.css">
 	<script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery.form.js"></script>

</head>
  <style>
  	#tbhead {
  		background-color: #2C394F;
  		color: #ffffff;
  		text-align: center;
      font-weight: lighter;
      font-size: 20px;
  	}
  	#del {
  		color: red;
  	}
  	h3 {
	color: #2C394F;
	}
	tbody{
		background-color: #ffffff;
    font-size: 15px;
	}
	/*border-radius*/
	.table-rounded thead th:first-child {
    border-radius: 15px 0 0 0;
	}
	.table-rounded thead th:last-child {
	    border-radius: 0 15px 0 0;
	}
	.table-rounded tbody td {
	    border: none;
      text-align: center;
	   /* border-top: solid 1px #957030;*/
	   /* background-color: #EED592;*/
	}
	.table-rounded tbody tr:last-child td:first-child {
	    border-radius: 0 0 0 15px;
	}
	.table-rounded tbody tr:last-child td:last-child {
	    border-radius: 0 0 15px 0;
	}
  </style>
  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลพนักงาน</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="../Project/source/cus_list.php" method="get" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสลูกค้า" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
			<a href="index.php?page=addnewStaff"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md">เพิ่มข้อมูลพนักงาน
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
          <td><?php echo $row->staff_id ?></td>
          <td><?php echo $row->staff_name ?></td>
          <td><?php echo $row->staff_surname ?></td>
          <td><?php echo $row->staff_passportid ?></td>
          <td><?php echo $row->staff_add ?></td>
          <td><?php echo $row->staff_stwd ?></td>
          <td><?php echo $row->staff_phone ?></td>
          <td> <a href="" style="text-decoration:none">view</a> |
              <a href="index.php?page=staffditForm&staff_id=<?= $row->staff_id; ?>" style="text-decoration:none">edit</a> |
              <a href="./source/edit.php?page=staffditForm&staff_id=<?= $row->staff_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }">delete</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

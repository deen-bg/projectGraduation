<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM payrollstaff WHERE salary_id LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();


$sql = "SELECT * FROM payrollstaff";

//prepare data after select//
$stmt = $db->prepare($sql);
		
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":salary_id", $salary_id, PDO::PARAM_INT);
$stmt->bindParam(":salary_paydate", $salary_paydate, PDO::PARAM_STR);
$stmt->bindParam(":salary_payroll", $salary_payroll, PDO::PARAM_INT);
$stmt->bindParam(":salary_status", $salary_status, PDO::PARAM_STR);
$stmt->bindParam(":salary_ovtWdr", $salary_ovtWdr, PDO::PARAM_INT);
$stmt->bindParam(":salary_receiveAm", $salary_receiveAm, PDO::PARAM_INT);
$stmt->bindParam(":salary_total", $salary_total, PDO::PARAM_INT);

$result = $stmt->execute(array(':salary_id'=>$salary_id, 
	':salary_paydate'=>$salary_paydate, ':salary_payroll'=>$salary_payroll, 
	':salary_status'=>$salary_status, ':salary_ovtWdr'=>$salary_ovtWdr, ':salary_receiveAm'=>$salary_receiveAm,
  ':salary_total'=>$salary_total)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show Product</title>
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
  		<b><h3>ข้อมูลการเบิกจ่ายเงินเดือนพนักงาน</h3></b>
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
			<a href="index.php?page=addnewstaffsalry"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md">เพิ่มข้อมูล
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
          <th>รหัสการเบิกจ่ายเงินเดือน</th>
          <th>วันที่จ่ายเงินเดือน</th>
          <th>เงินเดือน</th>
          <th>สถานะรับเงิน</th>
          <th>เบิกล่วงหน้า</th>
          <th>จำนวนเงินที่รับ</th>
          <th>ยอดรวม</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->salary_id ?></td>
          <td><?php echo $row->salary_paydate ?></td>
          <td><?php echo $row->salary_payroll ?></td>
          <td><?php echo $row->salary_status ?></td>
          <td><?php echo $row->salary_ovtWdr ?></td>
          <td><?php echo $row->salary_receiveAm ?></td>
          <td><?php echo $row->salary_total ?></td>
          <td> <a href="" style="text-decoration:none">view</a> |
              <a href="index.php?page=salaryEditform&salary_id=<?= $row->salary_id; ?>" style="text-decoration:none">edit</a> |
              <a href="./source/edit.php?page=salaryEditform&salary_id=<?= $row->salary_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }">delete</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

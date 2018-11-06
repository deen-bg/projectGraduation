<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM payrollstaff WHERE salary_paydate LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();


$sql = "SELECT payrollstaff.*, staff.staff_name, staff.staff_id 
FROM payrollstaff 
INNER JOIN staff ON payrollstaff.staffsalary_fid = staff.staff_id 
ORDER BY payrollstaff.salary_id";
//$sql = "SELECT * FROM payrollstaff";

$stmt = $db->prepare($sql);//prepare data after select//
		
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
</head>
  <body>
  	<div class="main">
  		<b><h3>ข้อมูลการเบิกจ่ายเงินเดือนพนักงาน</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=salary" method="post" >
		    <input class="form-control" type="date" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยวันที่" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href="index.php?page=staffsalary_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewstaffsalry"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่มข้อมูล</button></a>
	  	</div>
	</div>
</div>
  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
          <!--<th>รหัสการเบิกจ่ายเงินเดือน</th>-->
          <th>รหัสพนักงาน</th>
          <th>วันที่จ่ายเงินเดือน</th>
          <th>ค่าจ้าง</th>
          <th>เบิกล่วงหน้า</th>
          <th>จำนวนเงินที่รับ</th>
          <th>ยอดรวม</th>
          <th>สถานะรับเงิน</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <!--<td><?php echo $row->salary_id ?></td>-->
          <td><?php echo $row->staff_id.'.'.$row->staff_name ?></td>
          <td><?php echo $row->salary_paydate ?></td>
          <td><?php echo $row->salary_payroll ?></td>
          <td><?php echo $row->salary_ovtWdr ?></td>
          <td><?php echo $row->salary_receiveAm ?></td>
          <td><?php echo $row->salary_total ?></td>
           <td><?php echo $row->salary_status ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a> |
          <a href="index.php?page=salaryEditform&salary_id=<?= $row->salary_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</a></button> |
              <a href="./source/edit.php?page=salaryEditform&salary_id=<?= $row->salary_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

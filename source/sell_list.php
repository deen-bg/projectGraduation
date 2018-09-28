<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM sell WHERE isell_id LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();


$sql = "SELECT * FROM sell";

//prepare data after select//
$stmt = $db->prepare($sql);
		
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);
$stmt->bindParam(":sell_date", $sell_date, PDO::PARAM_STR);
$stmt->bindParam(":sell_price", $sell_price, PDO::PARAM_STR);
$stmt->bindParam(":sell_amount", $sell_amount, PDO::PARAM_STR);
$stmt->bindParam(":sell_total", $sell_total, PDO::PARAM_STR);
$stmt->bindParam(":sell_status", $sell_status, PDO::PARAM_STR);

$result = $stmt->execute(array(':sell_id'=>$sell_id, 
	':sell_date'=>$sell_date, ':sell_price'=>$sell_price, 
	':sell_amount'=>$sell_amount, ':sell_total'=>$sell_total, ':sell_status'=>$sell_status)); //5

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
  		<b><h3>ข้อมูลการขาย</h3></b>
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
			<a href="index.php?page=addnewrowSell"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md">เพิ่มข้อมูลการขาย
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
          <th>รหัสการขาย</th>
          <th>วันที่ขาย</th>
          <th>ราคา</th>
          <th>จำนวน</th>
          <th>ยอดรวม</th>
          <th>สถานะ</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->sell_id ?></td>
          <td><?php echo $row->sell_date ?></td>
          <td><?php echo $row->sell_price ?></td>
          <td><?php echo $row->sell_amount ?></td>
          <td><?php echo $row->sell_total ?></td>
          <td><?php echo $row->sell_status ?></td>
          <td> <a href="" style="text-decoration:none">view</a> |
              <a href="index.php?page=sellEditform&sell_id=<?= $row->sell_id; ?>" style="text-decoration:none">edit</a> |
              <a href="./source/edit.php?page=sellEditform&sell_id=<?= $row->sell_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }">delete</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

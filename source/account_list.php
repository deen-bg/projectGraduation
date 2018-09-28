<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM account WHERE account_id LIKE :search OR account_year LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();


$sql = "SELECT * FROM account";
$stmt = $db->prepare($sql);
		///bind variable from customer table  to variable in php

$stmt->bindParam(":account_id", $account_id, PDO::PARAM_INT);
$stmt->bindParam(":account_date", $account_date, PDO::PARAM_STR);
$stmt->bindParam(":account_year", $account_year, PDO::PARAM_STR);
$stmt->bindParam(":account_desc", $account_desc, PDO::PARAM_STR);
$stmt->bindParam(":account_itemtype", $account_itemtype, PDO::PARAM_STR);
$stmt->bindParam(":account_total", $account_total, PDO::PARAM_STR);

		//execute statatement
$stmt->execute();  ///stmt = statement

$result = $stmt->execute(array(':account_id'=>$account_id, 
	':account_date'=>$account_date, ':account_year'=>$account_year, 
	':account_desc'=>$account_desc, ':account_itemtype'=>$account_itemtype,
	':account_total'=>$account_total)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data account</title>
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
  #amount{
    padding: 5px;
    border-radius: 15px;
    font-size: 15px;
    font-weight: lighter;
    padding-left:120px;
    padding-right: 30px;
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
  		<b><h3>ข้อมูลรายรับ-รายจ่าย</h3></b>
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
			<a href="index.php?page=addnewAccount"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md">เพิ่มรายรับ-รายจ่าย
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
          <th>รหัสบัญชี</th>
          <th>วันที่</th>
          <th>ปี</th>
          <th>รายละเอียด</th>
          <th>ประเภท</th>
          <th>ยอดรวม</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $amount = 0;   //รวมยอดทั้งหมด
        $total =0;     //รวมยอดทั้งหมด
        $amount2 = 0; //รวมยอดรายจ่าย//
        $total2 =0;   //รวมยอดรายจ่าย//
        $amount3 = 0; //รวมยอดรายรับ//
        $total3 =0;   //รวมยอดรายรับ//

        while($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
          
          $INV_AMOUNT1 = $row->account_total;
          $total = $INV_AMOUNT1 + $total;
          $amount = $amount+ $total;

          if ($row->account_itemtype =='รายจ่าย')
          {

            $INV_AMOUNT2 = $row->account_total;
            $total2 = $INV_AMOUNT2 + $total2;
            $amount2 = $amount2+ $total2;
          }
          if ($row->account_itemtype =='รายรับ') {
            $INV_AMOUNT3 = $row->account_total;
            $total3 = $INV_AMOUNT3 + $total3;
            $amount3 = $amount3+ $total3;
          }
          ?>
        <tr>
          <td><?php echo $row->account_id ?></td>
          <td><?php echo $row->account_date ?></td>
          <td><?php echo $row->account_year ?></td>
          <td><?php echo $row->account_desc ?></td>
          <td><?php echo $row->account_itemtype ?></td>
          <td><?php echo $row->account_total ?></td>
          <td> <a href="" style="text-decoration:none">view</a> |
              <a href="index.php?page=accountditForm&account_id=<?= $row->account_id; ?>" style="text-decoration:none">edit</a> |
              <a href="./source/edit.php?page=accountditForm&account_id=<?= $row->account_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }">delete</a></td>
        </tr>
        <?php }?>
      </tbody>
    </table>
    <div class="col-md-auto" align="right">
      <table>

        <tr id="tbhead" style="height: 40px; margin-top: 80px;">
          <th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;"><?php  echo "รวมยอดรายจ่าย: "?>&nbsp;&nbsp;</th>
          <th id="amount"><?php  echo $total2; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;บาท</th>
        </tr>

        <tr id="tbhead" bgcolor="none" style="height: 40px; margin-top: 80px;">
          <th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;"><?php  echo "รวมยอดรายรับ: "?>&nbsp;&nbsp;</th>
          <th id="amount"><?php  echo $total3; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;บาท</th>
        </tr>

        <tr id="tbhead" style="height: 40px;">
          <th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;"><?php  echo "รวมยอดทั้งหมด: "?>&nbsp;&nbsp;</th>
          <span><th id="amount"><?php  echo $total; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;บาท</th></span>
        </tr>
      </table>
    </div>
</div>
</div>
<br>
<br>
  </body>
</html>

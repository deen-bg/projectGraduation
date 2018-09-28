<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM product WHERE product_name LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

//$sql = "SELECT product.*, producttype.producttype_name FROM product INNER JOIN producttype ON product.type_id = producttype.producttype_id ORDER BY product.product_id";
$sql = "SELECT * FROM product";

//$sql = "SELECT * FROM product INNER JOIN producttype ON product.type_id = producttype.producttype_id";
$stmt = $db->prepare($sql);

   ///bind variable from customer table  to variable in php
$stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
$stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
$stmt->bindParam(":product_pricepd", $product_pricepd, PDO::PARAM_STR);
$stmt->bindParam(":product_amountpd", $product_amountpd, PDO::PARAM_STR);
$stmt->bindParam(":product_status", $product_status, PDO::PARAM_STR);
//$stmt->bindParam(":type_id", $type_id, PDO::PARAM_STR);

		//execute statatement
$stmt->execute();  ///stmt = statement

$result = $stmt->execute(array(':product_id'=>$product_id, ':product_name'=>$product_name,
         ':product_pricepd'=>$product_pricepd, ':product_status'=>$product_status, ':product_amountpd'=>$product_amountpd));

?>
<!DOCTYPE html>
<html>
<head>
    <title>show Products</title>
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
  		<b><h3>ข้อมูลสินค้า</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="../Project/source/product_list.php" method="get" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสลูกค้า" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
			<a href="index.php?page=addnewProduct"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md">เพิ่มข้อมูลสินค้า
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
          <th>ชื่อสินค้า</th>
          <th>ราคาสินค้า</th>
          <th>จำนวนสินค้า</th>
          <th>สถานะ</th>
          <th>รหัสประเภท</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->product_id ?></td>
          <td><?php echo $row->product_name ?></td>
          <td><?php echo $row->product_price ?></td>
          <td><?php echo $row->product_amount ?></td>
          <td><?php echo $row->product_status ?></td>
          <td><?php echo $row->type_id ?></td>
          <td> <a href="" style="text-decoration:none">view</a> |
              <a href="index.php?page=productditForm&product_id=<?= $row->product_id; ?>" style="text-decoration:none">edit</a> |
              <a href="./source/edit.php?page=productditForm&product_id=<?= $row->product_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }">delete</a></td>
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

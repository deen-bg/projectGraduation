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

$sql = "SELECT product.*, producttype.producttype_name 
FROM product 
INNER JOIN producttype ON product.producttype_fid = producttype.producttype_id 
ORDER BY product.product_id";

$stmt = $db->prepare($sql);

   ///bind variable from customer table  to variable in php
$stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
$stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
$stmt->bindParam(":product_pricepd", $product_pricepd, PDO::PARAM_STR);
$stmt->bindParam(":product_amountpd", $product_amountpd, PDO::PARAM_STR);
$stmt->bindParam(":product_qty", $product_qty, PDO::PARAM_STR);
$stmt->bindParam(":product_status", $product_status, PDO::PARAM_STR);

$stmt->execute();  ////execute statatement

$result = $stmt->execute(array(':product_id'=>$product_id, ':product_name'=>$product_name,
         ':product_pricepd'=>$product_pricepd, ':product_amountpd'=>$product_amountpd, 
         ':product_qty'=>$product_qty, ':product_status'=>$product_status));

?>
<!DOCTYPE html>
<html>
<head>
    <title>show Products</title>
   <!-- <link rel="stylesheet" type="text/css" href="/Project/CSS/Form_login.css">-->
   <style type="text/css">
     /*Login*/
/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
    border-radius: 10px;
}
/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #DCDCDC;
}
.cancelbtn:hover{
  background-color: #BEBEBE;
}

.container {
    padding: 16px;
    width: 90%;

}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: center; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    float: center;
    overflow: hidden; /* hidden scroll bar*/
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
    padding-bottom: 80px;
}

/* Modal Content/Box */
.modal-content {
  /*  background-color: #fefefe; */
    margin: 5% auto 5% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 60%; /* Could be more or less, depending on screen size */
    position: center;
    float: center;
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)}
    to {-webkit-transform: scale(1)}
}
@keyframes animatezoom {
    from {transform: scale(0)}
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: center;
    }
    .cancelbtn {
       width: 100%;
    }
}
/*End login*/
   </style>
</head>
  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลสินค้า</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=product" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยชื่อสินค้า" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href="index.php?page=product_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
			<a href="index.php?page=addnewProduct"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูลสินค้า
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
        <!-- <th>วันที่ผลิต</th>-->
          <th>รหัสสินค้า</th>
          <th>ชื่อสินค้า</th>
          <th>ประเภท</th>
          <th>ราคาสินค้า</th>
          <th>บรรจุ/ชิ้น</th><!--product_amount-->
          <th>คงเหลือ/ชิ้น</th>
          <th>สถานะ</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
       <!-- <?php
       // while($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
         // foreach ($stmt as $rows)
          {
            //echo $rows['product_price'] . "\n";
          }
        }
?>-->
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){?>
        <tr>
          <td><?php echo $row->product_id ?></td>
          <td><?php echo $row->product_name ?></td>
          <td><?php echo $row->producttype_name ?></td>
          <td><?php echo $row->product_price ?></td>
          <td><?php echo $row->product_amount ?></td><!--บรรจุ/ชิ้น-->
          <td>
            <?php
              if($row->product_qty > 0)
              {
                echo $row->product_qty;
              }
              else
              {
                echo '<i style="background-color:red;">สินค้าหมด</i>';
              }
            ?>
          </td><!--สินค้าคงเหลือ-->
          <td>
            <?php
              if($row->product_qty > 0)
              {
                echo $row->product_status;
              }
              else
              {
                echo '<i style="background-color:red;">สินค้าหมด</i>';
              }
            ?>
          </td>
          <td>
            <a href="index.php?page=productditForm&product_id=<?= $row->product_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=productditForm&product_id=<?= $row->product_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php       //sum each row whare id//
    $sql = "SELECT product_price FROM product WHERE product_id IN (30, 31)";
    $stmt2 = $db->prepare($sql);
    $stmt2->bindParam(":product_id", $product_id, PDO::PARAM_INT);
    $stmt2->bindParam(":product_pricepd", $product_pricepd, PDO::PARAM_STR);

    $stmt2->execute();  ////execute statatement

$result2 = $stmt2->execute(array(':product_id'=>$product_id,
         ':product_pricepd'=>$product_pricepd));

     $amount = 0;   //รวมยอดทั้งหมด
     $total =0;     //รวมยอดทั้งหมด
     if ($stmt2->execute()) 
     {

       while($row = $stmt2->fetch(PDO::FETCH_OBJ))
        {            /*foreach($row as $key => $value)
            {
                echo "$key=$value";

            }*/
          echo $row->product_price. "<br>";
          //echo $row->product_id. "<br>";
         $INV_AMOUNT = $row->product_price;
              $total = $INV_AMOUNT + $total;
              $amount = $amount+ $total;

        }
          echo $total;


      }
          ?>
  </div>
  <br>
    <br>
    <br>
</div>
</body>
</html>
<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$sell_id = $_GET['sell_id'];
$sql = "SELECT sell.*, desc_sell.sell_fid, product.product_id, product.product_name, desc_sell.sell_price, 
desc_sell.sell_amount, desc_sell.sell_total, desc_sell.descsell_id, customer.cus_id, customer.cus_name, 
customer.cus_add 
FROM sell 
INNER JOIN desc_sell ON sell.sell_id = desc_sell.sell_fid 
INNER JOIN product ON desc_sell.product_fid = product.product_id
INNER JOIN customer ON sell.cus_fid = customer.cus_id
WHERE sell_id=:sell_id";
$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute([':sell_id' => $sell_id]);

$stmt2 = $db->prepare($sql);//prepare data after select//
$stmt2->execute([':sell_id' => $sell_id]);

////////////////////////////////////AVG////////////////////////////////////
/*$sql = "SELECT AVG(sell_total) AS Averagetotal FROM desc_sell";
$stmttotal = $db->prepare($sql);//prepare data after select//
$stmttotal->execute();
$sumtotal =0;
while($row = $stmttotal->fetch(PDO::FETCH_OBJ))
      {
        $sumtotal = $row->Averagetotal;
      }
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$sumtotal;*/
///////////////////////////////END//////////////////////////////////////////
$sql ="SELECT sell.sell_date,sell.sell_status,SUM(`sell_total`) AS total 
FROM desc_sell 
INNER JOIN sell ON desc_sell.sell_fid = sell.sell_id 
WHERE `sell_date` LIKE '%2018%' GROUP BY sell.sell_date";
$stmttotal = $db->prepare($sql);//prepare data after select//
$stmttotal->execute();
$sumtotal =0;
while($row = $stmttotal->fetch(PDO::FETCH_OBJ))
      {
        echo $row->sell_date;
        echo $row->sell_status;
        $sumtotal = $row->total;
      }
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$sumtotal;

?>
<!DOCTYPE html>
<html>
<head>
    <title>show Desc selling</title>
     <style>
  #amount{
    padding: 5px;
    border-radius: 15px;
    font-size: 15px;
    font-weight: lighter;
    padding-left:120px;
    padding-right: 30px;
  }

  </style>
</head>
  <body>
  	<div class="main">
  		<b><h3>รายละเอียดการขาย</h3></b>
  		<br>
  		<br>
<?php
$round = true;
       while($rows = $stmt2->fetch(PDO::FETCH_OBJ))
        { ?>
           <?php if ($round) 
          { ?>
           <td><?php echo "ชื่อลูกค้า:&nbsp;".$rows->cus_name ?></td><br>
            <td><?php echo "ที่อยู่ลูกค้า:&nbsp;".$rows->cus_add ?></td><br>
             <?php $round = false;
              }
          else
            { ?>
              <td></td>
              <td></td>
            <?php } ?>
      <?php } ?>
  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
        <th>รหัสรายละเอียดการขาย</th>
          <th>รหัสการการขาย</th><!--Fk-->
         <!-- <th>รหัสลูกค้า</th><!--Fk-->
         <!-- <th>ชื่อลูกค้า</th>-->
          <th>รหัสสินค้า</th><!--Fk-->
          <th>ชื่อสินค้า</th>
          <th>ราคาสินค้า</th>
          <th>จำนวน</th>
          <th>ยอดรวม</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
         $total =0;     //รวมยอดทั้งหมด
        $round = true;
        while($row = $stmt->fetch(PDO::FETCH_OBJ))
        {
          $sum = $row->sell_total;
            $total = $sum + $total;
         ?>
          <?php if ($round) 
          { ?>
            <tr>
             <td><?php echo $row->descsell_id ?></td>
               <td><?php echo $row->sell_fid ?></td> <!--Fk manufac table-->
             <!--  <td><?php //echo $row->cus_id ?></td> <!--Fk manufac table-->
             <!--  <td><?php //echo $row->cus_name ?></td> <!--Fk manufac table-->
               <td><?php echo $row->product_id ?></td> <!--Fk manufac table-->
               <td><?php echo $row->product_name ?></td> <!--Fk manufac table-->
               <td><?php echo $row->sell_price ?></td>
               <td><?php echo $row->sell_amount ?></td>
               <td><?php echo $row->sell_total ?></td>
               <td><a href="index.php?page=sell_desc_report&sell_id=<?= $row->sell_id; ?>" title="พิมพ์ใบแจ้งหนี้"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md" ><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;</td>
            </tr>
            <?php $round = false;
          }
          else
            { ?>
              <tr>
              <td></td>
              <td></td>
              <td><?php echo $row->product_id ?></td> <!--Fk manufac table-->
              <td><?php echo $row->product_name ?></td> <!--Fk manufac table-->
              <td><?php echo $row->sell_price ?></td>
              <td><?php echo $row->sell_amount ?></td>
              <td><?php echo $row->sell_total ?></td>
               <td></td>
            </tr>
            <?php } ?>
        <?php } ?>
      </tbody>
    </table>
     <div class="col-md-auto" align="right">
      <table>
        <tr id="tbhead" style="height: 40px;">
          <th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;"><?php  echo "ยอดรวมสุทธิ: "?>&nbsp;&nbsp;</th>
          <span><th id="amount"><?php  echo $total; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;บาท</th></span>
        </tr>
      </table>
    </div>
</div>
</div>
  </body>
</html>
<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$manufac_id = $_GET['manufac_id'];
$sql = "SELECT manufacture.*, product.product_id, product.product_name, desc_manufac.descmnf_fid, 
desc_manufac.descmtr_fid, desc_manufac.manufac_QtyrMtr, rawmaterial.matr_name 
FROM manufacture 
INNER JOIN product ON manufacture.manufac_pfid = product.product_id 
INNER JOIN desc_manufac ON manufacture.manufac_id = desc_manufac.descmnf_fid 
INNER JOIN rawmaterial ON desc_manufac.descmtr_fid = rawmaterial.matr_id
WHERE manufac_id=:manufac_id
ORDER BY manufacture.manufac_id ";
$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute([':manufac_id' => $manufac_id]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>show Desc Manufacture</title>
</head>
  <body>
  	<div class="main">
  		<b><h3>รายละเอียดการผลิต</h3></b>
  		<br>
  		<br>

  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
          <th>รหัสการผลิต</th>
          <th>วันที่ผลิต</th>
          <th>รหัสสินค้า</th>
          <th>ชื่อสินค้า</th>
          <th>วัตถุดิบที่ใช้</th>
          <th>ปริมาณ/หน่วย</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $round = true;
        while($row = $stmt->fetch(PDO::FETCH_OBJ))
        { ?>
          <?php if ($round) 
          { ?>
            <tr>
               <td><?php echo $row->descmnf_fid ?></td> <!--Fk manufac table-->
              <td><?php echo $row->manufac_date ?></td>
              <td><?php echo $row->product_id ?></td>
               <td><?php echo $row->product_name ?></td>
               <td><?php echo $row->descmtr_fid.'.'.$row->matr_name ?></td>
               <td><?php echo $row->manufac_QtyrMtr ?></td>
               <td><a href="index.php?page=manufac_desc_report&manufac_id=<?= $row->manufac_id; ?>">
                <button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a></td>
            </tr>
            <?php $round = false;
          }
          else
            { ?>
              <tr>
                 <td></td>
                <td></td>
                <td></td>
                 <td></td>
                 <td><?php echo $row->descmtr_fid.'.'.$row->matr_name ?></td>
                 <td><?php echo $row->manufac_QtyrMtr ?></td>
                 <td></td>
              </tr>
            <?php } ?>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>

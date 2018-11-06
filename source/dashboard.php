<?php
//session_start();

require_once("../Project/database/Db.php"); //Connect Db
$objDb = new Db();
$db = $objDb->database;

//select account table
$sql = "SELECT * FROM account";
$stmt = $db->prepare($sql);
$stmt->execute();
//////////END/////////////

////select sell table///
$sql = "SELECT * FROM desc_sell";
$stmt_sell = $db->prepare($sql);
$stmt_sell->execute();
////////END///////////////

//select inventory table////
$sql = "SELECT * FROM product";
//prepare data after select//
$stmt_pd = $db->prepare($sql);
$stmt_pd->execute();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
<style type="text/css"> /*Dashboard only use */
#dash{
  height: 700px;
  border-radius: 30px;
  padding-top: 50px;
  text-align: center;
  margin-right: 20px;
  font-size: 30px;
}
</style>
</head>
<body>
<!--Content!-->
<div class="main">
      <b><h2>ภาพรวม</h2></b>
      <br>
      <br>
      <br>
  <!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
    <?php
        $total3 =0;   //รวมยอดรายรับทั้งหมด//
          while($row = $stmt->fetch(PDO::FETCH_OBJ))
          {
            if ($row->account_itemtype =='รายรับ')
            {
              $INV_AMOUNT3 = $row->account_total;
              $total3 = $INV_AMOUNT3 + $total3;
           }
          }
      ?>
      <div class="row">
        <div class="col-sm bg-light shadow p-3 mb-5" id="dash">รายได้ทั้งหมด<br>
         <br>
          <br>
          <br>
           <th id="amount" style="margin-top: 300px;"><?php  echo $total3; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;</th>
          <br>
          <br>
          <br>
          <i class="fa fa-credit-card fa-3x" aria-hidden="true" style="color: #21BAA1"></i>
          <br>
          <br>
          <br>
          บาท
        </div>

        <?php
          $sell_total =0;// จำนวนที่ขายได้
          while($row = $stmt_sell->fetch(PDO::FETCH_OBJ))
          {
            if ($row->sell_amount)
              {
                $INV_SELL = $row->sell_amount;
                $sell_total = $INV_SELL + $sell_total;
             }
          }
        ?>
        <div class="col-sm bg-light shadow p-3 mb-5" id="dash">การขาย<br>
          <br>
          <br>
          <br>
          <span><th id="amount" style="margin-top: 300px;"><?php  echo $sell_total; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;</th></span>
          <br>
          <br>
          <br>
          <i class="fa fa-shopping-cart fa-3x" aria-hidden="true" style="color: #21BAA1"></i>
          <br>
          <br>
          <br>
          รายการ
        </div>

        <?php
        $pd_total =0; //จำนวนสินค้าในคลัง

          while($row = $stmt_pd->fetch(PDO::FETCH_OBJ))
          {

            if ($row->product_qty)
              {
                $PD_INVENTR = $row->product_qty;
                $pd_total = $PD_INVENTR + $pd_total;
             }
          }
        ?>
        <div class="col-sm bg-light shadow p-3 mb-5" id="dash">สินค้าคงเหลือทั้งหมด
          <br>
          <br>
          <br>
          <br>
          <span>
            <th id="amount" style="margin-top: 300px;">
            <?php
                 if($pd_total > 0)
          {
            echo $pd_total;
          }
          else
          {
            echo '<i style="background-color:red;">สินค้าหมด</i>';
          }
          //  echo $pd_total; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;</th></span>
          <br>
          <br>
          <br>
            <i class="fa fa-archive fa-3x" aria-hidden="true" style="color: #21BAA1"></i>
            <br>
            <br>
            <br>
            ชิ้น
        </div>
      </div>
</div>
</body>
</html>
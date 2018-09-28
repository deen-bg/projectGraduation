<?php
//session_start();

require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

//select account table
$sql = "SELECT * FROM account";
$stmt = $db->prepare($sql);
$stmt->execute();
//////////END/////////////

////select sell table///
$sql = "SELECT * FROM sell";
$stmt_sell = $db->prepare($sql);
$stmt_sell->execute();
////////END///////////////

//select inventory table////
$sql = "SELECT * FROM inventory";
//prepare data after select//
$stmt_inventr = $db->prepare($sql);
$stmt_inventr->execute();

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="Project/fontawesome-free-5.3.1-web/fontawesome-free-5.3.1-web/css/fontawesome.css">
  <link rel="stylesheet" type="text/css" href="/Project/fontawesome-free-5.3.1-web/fontawesome-free-5.3.1-web/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="/Project/CSS/Form_login.css">
 <script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>

<style type="text/css">
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
        $total3 =0;   //รวมยอดรายรับ//
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
          $sell_total =0;// จำนวนขาย
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
        $invtr_total =0; //จำนวนสินค้าในคลัง

          while($row = $stmt_inventr->fetch(PDO::FETCH_OBJ))
          {

            if ($row->invent_amount)
              {
                $INV_INVENTR = $row->invent_amount;
                $invtr_total = $INV_INVENTR + $invtr_total;
             }
          }
        ?>
        <div class="col-sm bg-light shadow p-3 mb-5" id="dash">สินค้าในคลัง
          <br>
          <br>
          <br>
          <br>
          <span><th id="amount" style="margin-top: 300px;"><?php  echo $invtr_total; ?></th><th bgcolor="#DCDCDC" style="color: black; font-weight: lighter;">&nbsp;</th></span>
          <br>
          <br>
          <br>
            <i class="fa fa-archive fa-3x" aria-hidden="true" style="color: #21BAA1"></i>
            <br>
            <br>
            <br>
            <i class="fa fa-book fa-fw" aria-hidden="true"></i>
            ชิ้น
        </div>
      </div>
</div>
</body>
</html>
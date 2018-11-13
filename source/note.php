<?php
////////////////////////////////////AVG////////////////////////////////////
$sql = "SELECT AVG(sell_total) AS Averagetotal FROM desc_sell";
$stmttotal = $db->prepare($sql);//prepare data after select//
$stmttotal->execute();
$sumtotal =0;
while($row = $stmttotal->fetch(PDO::FETCH_OBJ))
      {
        $sumtotal = $row->Averagetotal;
      }
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$sumtotal;
//////////////////////////////////END///////////////////////////////////////
////////////////count rows where column//////////////
/*$sql = "SELECT COUNT(producttype_fid) as test 
FROM product
WHERE producttype_fid =1";
$stmt4 = $db->prepare($sql);
$stmt4->execute();
$sumtotal =0;
while($row = $stmt4->fetch(PDO::FETCH_OBJ))
      {
        $sumtotal = $row->test;
      }
      echo $sumtotal;*/
////////////////////////////////////END////////////
////////////////////////////////////sum each row whare IN Pk///////////////////////////
   /* $sql = "SELECT product_price FROM product WHERE product_id IN (30, 31)";
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
          /*echo $row->product_price. "<br>";
          //echo $row->product_id. "<br>";
         $INV_AMOUNT = $row->product_price;
              $total = $INV_AMOUNT + $total;
              $amount = $amount+ $total;*/

        }
         // echo $total;
//////////////////////////////////////END///////////////////////////////////////////////
?>
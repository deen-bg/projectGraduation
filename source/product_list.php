<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

////////////////////////////////////////Search///////////////////////////////////////////////
$search= '';      //Search//
if (isset($_POST['varsearch'])) 
{
  $varsearch = $_POST['varsearch'];
  $search = " WHERE `product_name` LIKE '%$varsearch%' OR `producttype_name` LIKE '%$varsearch%' ";
}
/////////////////////////////////////////////////////////////////////////////////////////////
                    //Select table customer for Serach//
/*$sql = "SELECT * FROM customer $search";
$stmt = $db->prepare($sql);
$stmt->execute();*/
////////////////////END/////////////////////////////////////////////////////////////////////////////

$sql = "SELECT product.*, producttype.producttype_name 
FROM product
INNER JOIN producttype ON product.producttype_fid = producttype.producttype_id 
$search 
ORDER BY product.product_id";
$stmt = $db->prepare($sql);


 /*  ///bind variable from customer table  to variable in php
$stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
$stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
$stmt->bindParam(":product_pricepd", $product_pricepd, PDO::PARAM_STR);
$stmt->bindParam(":product_amountpd", $product_amountpd, PDO::PARAM_STR);
$stmt->bindParam(":product_qty", $product_qty, PDO::PARAM_STR);
$stmt->bindParam(":product_status", $product_status, PDO::PARAM_STR);*/

$stmt->execute();  ////execute statatement

/*$result = $stmt->execute(array(':product_id'=>$product_id, ':product_name'=>$product_name,
         ':product_pricepd'=>$product_pricepd, ':product_amountpd'=>$product_amountpd, 
         ':product_qty'=>$product_qty, ':product_status'=>$product_status));*/



?>
<!DOCTYPE html>
<html>
<head>
    <title>show Products</title>
 
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
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยชื่อสินค้า/ประเภท" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href="index.php?page=product_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;
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
       <!--   <th>รหัสสินค้า</th>-->
          <th>ชื่อสินค้า</th>
          <th>ประเภท</th>
          <th>ราคาสินค้า</th>
          <th>บรรจุ/ชิ้น</th><!--product_amount-->
          <th>คงเหลือ/ชิ้น</th>
          <th>สถานะ</th>
          <th>จัดการข้อมูล
          <button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i>ลบที่เลือก</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>
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
          <td><?php echo $row->product_name ?></td>
          <td><?php echo $row->producttype_name ?></td>
          <td><?php echo $row->product_price ?></td>
          <td><?php echo $row->product_amount ?></td><!--บรรจุ/ชิ้น-->
          <td>
            <?php
              if($row->product_qty > 0)
              {
                echo $row->product_qty; //show qty
              }
              elseif($row->product_qty == 0 and $row->product_status =='สินค้าใหม่')
              {
                echo '<i style="background-color:orange;">ยังไม่ได้ผลิต</i>';
              }
              else{
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
              elseif ($row->product_status =='สินค้าใหม่')
              {
                echo '<i style="background-color:orange;">ยังไม่ได้ผลิต</i>';
              }
            ?>
          </td>
          <td>
            <a href="index.php?page=productditForm&product_id=<?= $row->product_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=productditForm&product_id=<?= $row->product_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>
              <input class="checkbox" type="checkbox" id="<?php echo $row->product_id; ?>" name="id[]"></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

    <?php       //sum each row whare id//
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

      /*  }
         // echo $total;


      }*/
          ?>

<?php
////////////////count rows where column
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
      ?>
<?php
//////////////////Count rows all/////////////////////////
$sql ="SELECT COUNT(product_id) as test
FROM product WHERE product_id";
$stmt3 = $db->prepare($sql);
$stmt3->execute();
$sumtotal =0;
 while($row = $stmt3->fetch(PDO::FETCH_OBJ))
      {
        $sumtotal = $row->test;
      }
      echo 'จำนวนแถวทั้งหมด&nbsp;'.$sumtotal.'&nbsp;แถว';
      ////////////////////////////END/////////////////
      ?> 

  </div>
  <br>
    <br>
    <br>
</div>

<!--------Delete multiple records using checkbox in PHP and MySQL without refreshing page------>
<script>
  $(document).ready(function(){
      $('#checkAll').click(function(){
         if(this.checked){
             $('.checkbox').each(function(){
                this.checked = true;
             });   
         }else{
            $('.checkbox').each(function(){
                this.checked = false;
             });
         } 
      });
    $('#delete').click(function(){
       var dataArr  = new Array();
       if($('input:checkbox:checked').length > 0){
          $('input:checkbox:checked').each(function(){
              dataArr.push($(this).attr('id'));
              $(this).closest('tr').remove();
          });
          sendResponse(dataArr)
       }else{
         alert('กรุณาเลือกถูกในช่อง [/] ก่อน! ');
       }
    });
    function sendResponse(dataArr){
        $.ajax({
            type    : 'post',
            url     : './source/edit.php',
            data    : {'datapd' : dataArr},
            success : function(response){
                        alert(response);
                      },
            error   : function(errResponse){
                      alert(errResponse);
                      }
        });
    }
  });
</script>
<!--------Delete multiple records using checkbox in PHP and MySQL without refreshing page------>
</body>
</html>
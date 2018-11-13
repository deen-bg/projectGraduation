<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$search= '';      //Search//
if (isset($_POST['varsearch'])) 
{
  $varsearch = $_POST['varsearch'];
  $search = " WHERE `account_itemtype` LIKE '%$varsearch%' OR `account_desc` LIKE '%$varsearch%' ";
}
/////////////////////////////////////////////////////////////////////////////////////////////
                    //Select table customer for Serach//
$sql = "SELECT * FROM account $search";
$stmt = $db->prepare($sql);
$stmt->execute();
////////////////////END/////////////////////////////////////////////////////////////////////////////
/*
$sql = "SELECT * FROM account";
$stmt = $db->prepare($sql);

    ///bind variable from customer table  to variable in php
$stmt->bindParam(":account_id", $account_id, PDO::PARAM_INT);
$stmt->bindParam(":account_date", $account_date, PDO::PARAM_STR);
$stmt->bindParam(":account_year", $account_year, PDO::PARAM_STR);
$stmt->bindParam(":account_desc", $account_desc, PDO::PARAM_STR);
$stmt->bindParam(":account_itemtype", $account_itemtype, PDO::PARAM_STR);
$stmt->bindParam(":account_total", $account_total, PDO::PARAM_STR);

$stmt->execute();  //execute statatement

$result = $stmt->execute(array(':account_id'=>$account_id, 
	':account_date'=>$account_date, ':account_year'=>$account_year, 
	':account_desc'=>$account_desc, ':account_itemtype'=>$account_itemtype,
	':account_total'=>$account_total)); //5*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>show data account</title>
</head>
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
  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลรายรับ-รายจ่าย</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
    <form class="form-inline" action="index.php?page=finance" method="post" >
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยประเภท/รายการ" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
  
	<div class="col-sm-3" align="right">
		<div class="btn-group">
       <a href="index.php?page=account_reportExpenditure"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์รายจ่าย</button></a>&nbsp;
        <a href="index.php?page=accountReport"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์รายรับ</button></a>&nbsp;
			<a href="index.php?page=addnewAccount"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่ม
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
          <th>วันที่</th>
          <th>รายการ</th>
          <th>ประเภท</th>
          <th>ยอดรวม(THB.)</th>
          <th>จัดการข้อมูล&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger btn-sm" id="delete">
            <i class="fa fa-trash" aria-hidden="true"></i>ลบที่เลือก</button>&nbsp;&nbsp;&nbsp;
            <input type="checkbox" id="checkAll"></th>
        </tr>
      </thead>
      <tbody>

        <?php
          $total =0;     //รวมยอดทั้งหมด
          $total2 =0;   //รวมยอดรายจ่าย//
          $amount3 = 0; //รวมยอดรายรับ//
          $total3 = 0;

          while($row = $stmt->fetch(PDO::FETCH_OBJ))
          {

            $INV_AMOUNT1 = $row->account_total;
            $total = $INV_AMOUNT1 + $total;
         //   $amount = $amount+ $total;

            if ($row->account_itemtype =='รายจ่าย')
            {
              $INV_AMOUNT2 = $row->account_total;
              $total2 = $INV_AMOUNT2 + $total2;
         //     $amount2 = $amount2+ $total2;
            }
            if ($row->account_itemtype =='รายรับ') {
              $INV_AMOUNT3 = $row->account_total;
              $total3 = $INV_AMOUNT3 + $total3;
           //   $amount3 = $amount3+ $total3;
            }
            ?>
        <tr>
          <td><?php echo $row->account_date ?></td>
          <td><?php echo $row->account_desc ?></td>
          <td><?php echo $row->account_itemtype ?></td>
          <td><?php echo $row->account_total ?></td>
          <td>
          <a href="index.php?page=accountditForm&account_id=<?= $row->account_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</a></button> |
              <a href="./source/edit.php?page=accountditForm&account_id=<?= $row->account_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>
              <input class="checkbox" type="checkbox" id="<?php echo $row->account_id; ?>" name="id[]"></td>
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
            data    : {'dataaccount' : dataArr},
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

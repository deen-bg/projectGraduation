<?php
//session_start();

require_once("../Project/database/Db.php"); //require connect Db file//
$objDb = new Db();
$db = $objDb->database;
////////////////////////////////////////Search///////////////////////////////////////////////
$search= '';      //Search//
if (isset($_POST['varsearch'])) 
{
  $varsearch = $_POST['varsearch'];
  $search = " WHERE `cus_name` LIKE '%$varsearch%' OR `cus_surname` LIKE '%$varsearch%' ";
}
/////////////////////////////////////////////////////////////////////////////////////////////
                    //Select table customer for Serach//
$sql = "SELECT * FROM customer $search";
$stmt = $db->prepare($sql);
$stmt->execute();
////////////////////END/////////////////////////////////////////////////////////////////////////////

// $sql = "SELECT * FROM customer ";      //Select table customer//
// $stmt = $db->prepare($sql);          //prepare statment $sql//

//     ///bind variable from customer table for variable in php
// $stmt->bindParam(":cus_id", $cus_id, PDO::PARAM_INT);
// $stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
// $stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
// $stmt->bindParam(":gen_radio", $gen_radio, PDO::PARAM_STR);
// $stmt->bindParam(":cus_mail", $cus_mail, PDO::PARAM_STR);
// $stmt->bindParam(":cus_phone", $cus_phone, PDO::PARAM_STR);
// $stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);
// $stmt->execute();  ///stmt = statement
// $result = $stmt->execute(array(':cus_id'=>$cus_id, 
// 	':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
// 	':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
// 	':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add)); //5
////////////////////////////END//////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html>
<html>
<head>
  <title>show data customer</title>
</head>
  <body>
  	<div class="main">
  		<br>
  		<br>
      <div style="text-align:right;"> <?php date_default_timezone_set("Asia/Bangkok");
              echo date('d-m-Y H:i:s');//Returns IST?> </div>
  		<b><h3>ข้อมูลลูกค้า</h3></b>
  		<br>
  		<br>
<div class="row">

	<div class="col-8">
		<form class="form-inline" action="index.php?page=customer" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยชื่อ/นามสกุล" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
  
	<div class="col-sm-4" align="right">
		<div class="btn-group">
       <a href="index.php?page=Cusreport"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;
			<a href="index.php?page=addnewCus"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่มลูกค้า
			</button></a>
	  	</div>
	</div>
</div>
  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded"> <!--Table!-->
      <thead>
        <tr id="tbhead">
          <th>ชื่อลูกค้า</th>
          <th>นามสกุล</th>
          <th>เพศ</th>
          <th>อีเมล์</th>
          <th>เบอร์โทร</th>
          <th>ที่อยู่</th>
          <th>จัดการข้อมูล&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" 
            aria-hidden="true"></i>ลบที่เลือก</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->cus_name ?></td>
          <td><?php echo $row->cus_surname ?></td>
          <td><?php echo $row->cus_gender ?></td>
          <td><?php echo $row->cus_mail ?></td>
          <td><?php echo $row->cus_phone ?></td>
          <td><?php echo $row->cus_add ?></td>
          <td>
              <a href="index.php?page=cuseditForm&cus_id=<?= $row->cus_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</a></button> |
              <a href="./source/edit.php?page=customer&cus_id=<?= $row->cus_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>&nbsp;&nbsp;
              <input class="checkbox" type="checkbox" id="<?php echo $row->cus_id; ?>" name="id[]"></td>
        </tr>
        <?php } ?>
      </tbody>
    </table> <!--END table!-->
</div>
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
            data    : {'datacus' : dataArr},
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

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
  $search = " WHERE `staff_name` LIKE '%$varsearch%' OR `staff_surname` LIKE '%$varsearch%' ";
}
/////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM staff $search";
$stmt = $db->prepare($sql);

    /*///bind variable from customer table  to variable in php
$stmt->bindParam(":staff_id", $staff_id, PDO::PARAM_INT);
$stmt->bindParam(":staff_name", $staff_name, PDO::PARAM_STR);
$stmt->bindParam(":staff_surname", $staff_surname, PDO::PARAM_STR);
$stmt->bindParam(":staff_passportid", $staff_passportid, PDO::PARAM_STR);
$stmt->bindParam(":staff_add", $staff_add, PDO::PARAM_STR);
$stmt->bindParam(":staff_stwd", $staff_stwd, PDO::PARAM_STR);
$stmt->bindParam(":staff_phone", $staff_phone, PDO::PARAM_STR);*/

$stmt->execute();  //execute statatement

/*$result = $stmt->execute(array(':staff_id'=>$staff_id, 
	':staff_name'=>$staff_name, ':staff_surname'=>$staff_surname, 
	':staff_passportid'=>$staff_passportid, ':staff_add'=>$staff_add,
	':staff_stwd'=>$staff_stwd, ':staff_phone'=>$staff_phone)); //5*/

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Staff</title>
</head>

  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลพนักงาน</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
    <form class="form-inline" action="index.php?page=staff" method="post" >
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยชื่อ/นามสกุล" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href="index.php?page=staff_report"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;
			<a href="index.php?page=addnewStaff"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูลพนักงาน</button></a>
	  	</div>
	</div>
</div>
  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
          <th>ชื่อพนักงาน</th>
          <th>นามสกุล</th>
          <th>เลขบัตรประชาชน</th>
          <th>ที่อยู่</th>
          <th>วันที่เข้าทำงาน</th>
          <th>เบอร์โทร</th>
          <th>จัดการข้อมูล&nbsp;&nbsp;
          <button type="button" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash" aria-hidden="true"></i>ลบที่เลือก</button>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="checkAll"></th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->staff_name ?></td>
          <td><?php echo $row->staff_surname ?></td>
          <td><?php echo $row->staff_passportid ?></td>
          <td><?php echo $row->staff_add ?></td>
          <td><?php echo $row->staff_stwd ?></td>
          <td><?php echo $row->staff_phone ?></td>
          <td>
              <a href="index.php?page=staffditForm&staff_id=<?= $row->staff_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> |
              <a href="./source/edit.php?page=staffditForm&staff_id=<?= $row->staff_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>
              <input class="checkbox" type="checkbox" id="<?php echo $row->staff_id; ?>" name="id[]"></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
<!-- <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav> -->
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
            data    : {'datastaff' : dataArr},
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

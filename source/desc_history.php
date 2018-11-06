<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$maintn_id = $_GET['maintn_id'];
$varsearch = '';
$query = "SELECT * FROM macchine_history WHERE mch_id LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

/*$sql = "SELECT macchine_history.*, maintenance.maintn_id, macchine_history.maintn_fid 
FROM macchine_history 
INNER JOIN maintenance ON macchine_history.maintn_fid = maintenance.maintn_id 
ORDER BY macchine_history.mch_id";

$stmt = $db->prepare($sql);

   ///bind variable from customer table  to variable in php
$stmt->bindParam(":macchine_history", $macchine_history, PDO::PARAM_INT);
$stmt->execute();  ////execute statatement
$result = $stmt->execute(array(':macchine_history'=>$macchine_history));*/
////////////////////////////////////////////////////////////////////////////////////
//$manufac_id = $_GET['manufac_id'];
$sql = "SELECT maintenance.*, maintenance.maintn_id, macchine_history.maintn_fid, macchine_history.mch_id, macchine_history.mch_date, macchine_history.mch_desc, macchine_history.mch_title 
FROM maintenance 
INNER JOIN macchine_history ON maintenance.maintn_id = macchine_history.maintn_fid 
WHERE maintn_id=:maintn_id 
ORDER BY maintenance.maintn_id ";
$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute([':maintn_id' => $maintn_id]);
///////////////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html>
<html>
<head>
    <title>show maitenance history</title>

</head>
  <body>
  	<div class="main">
  		<br>
      <br>
  		<b><h3>ข้อมูลประวัตการซ่อม</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=desc_sell" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสการขาย" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
      <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
     <!-- <a href="index.php?page=addnewdescsell"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;เพิ่มข้อมูล
      </button></a>-->
	  	</div>
	</div>
</div>
  <p></p>
  <p></p>
  <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
          <th>Pk</th>
          <th>รหัสเครื่องจักร</th>
          <th>Fk</th>
          <th>วันที่</th>
          <th>รายละเอียด</th>
          <th>ชื่อผู้ซ่อม</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->mch_id ?></td>
           <td><?php echo $row->maintn_id ?></td>
          <td><?php echo $row->maintn_fid ?></td>
          <td><?php echo $row->mch_date ?></td>
          <td><?php echo $row->mch_desc ?></td>
          <td><?php echo $row->mch_title ?></td>
          <td> <a href="" style="text-decoration:none">ดู</a><!-- |
            <a href="index.php?page=descsellditForm&descsell_id=<?= $row->descsell_id; ?>" style="text-decoration:none color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</button></a> <!--|
              <a href="./source/edit.php?page=descsellditForm&descsell_id=<?= $row->descsell_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a>--></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <br>
    <br>
    <br>
    <br>
</div>
</body>
</html>

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

$sql = "SELECT maintenance.*, maintenance.maintn_title, macchine_history.maintn_fid, macchine_history.mch_id, macchine_history.mch_date, macchine_history.mch_desc, macchine_history.mch_title 
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
  		<b><h3>ข้อมูลประวัติการซ่อม</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="index.php?page=desc_sell" method="post" >
		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสการขาย" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
  <br>
  <br>
  <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
          <th>ชื่อเครื่องจักร</th>
          <th>วันที่ซ่อม</th>
          <th>รายการซ่อม</th>
          <th>ชื่อผู้ซ่อม</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $round = true;
         while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
           <?php if ($round) 
          { ?>
        <tr>
           <td><?php echo $row->maintn_title ?></td>
          <td><?php echo $row->mch_date ?></td>
          <td><?php echo $row->mch_desc ?></td>
          <td><?php echo $row->mch_title ?></td>
          <td><a href="index.php?page=maitenance_report&maintn_id=<?= $row->maintn_id; ?>" title="พิมพ์ใบแจ้งหนี้"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md" ><i class="fa fa-print" aria-hidden="true"></i>&nbsp;พิมพ์</button></a>&nbsp;</td>
        </tr>
         <?php $round = false;
          }
          else
            { ?>
               <tr>
               <td></td>
                <td><?php echo $row->mch_date ?></td>
                <td><?php echo $row->mch_desc ?></td>
                <td><?php echo $row->mch_title ?></td>
                <td></td>
            </tr>
            <?php } ?>
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

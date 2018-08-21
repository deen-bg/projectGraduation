<?php
//session_start();
require_once("../database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$sql = "SELECT * FROM customer";
$search ='';
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$sql .= " WHERE cus_name LIKE '%".$search."%' OR cus_surname LIKE '%".$search."%'";
}

$stmt = $db->prepare($sql);


		///bind variable from customer table  to variable in php
/*
$stmt->bindParam(":cus_id", $cus_id, PDO::PARAM_INT);
$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
$stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
$stmt->bindParam(":gen_radio", $gen_radio, PDO::PARAM_STR);
$stmt->bindParam(":cus_mail", $cus_mail, PDO::PARAM_STR);
$stmt->bindParam(":cus_phone", $cus_phone, PDO::PARAM_STR);
$stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);
*/
		//execute statatement
$stmt->execute();  ///stmt = statement
/*
$result = $stmt->execute(array(':cus_id'=>$cus_id, 
	':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
	':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
	':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add)); //5
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <a href="">เพิ่มข้อมูล</a>
    <form class="" action="../Project/source/cus_list.php" method="get">
      <input type="text" name="search" value="<?php echo $search ?>">
      <button type="submit">Search</button>
    </form>
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>customer name</th>
          <th>customer surname</th>
          <th>gender</th>
          <th>mail</th>
          <th>phone</th>
          <th>address</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->cus_id ?></td>
          <td><?php echo $row->cus_name ?></td>
          <td><?php echo $row->cus_surname ?></td>
          <td><?php echo $row->cus_gender ?></td>
          <td><?php echo $row->cus_mail ?></td>
          <td><?php echo $row->cus_phone ?></td>
          <td><?php echo $row->cus_add ?></td>
          <td> <a href="">view</a> |
              <a href="">edit</a> |
              <a href="" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }">delete</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </body>
</html>

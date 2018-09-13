<?php
session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

if (empty($_SESSION['username']))
  header('Location: Form_login.php');
?> 

<!DOCTYPE html>
<html>
<head>
	<title>index</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
			<!--sidebar & navbar!-->
	<link rel="stylesheet" type="text/css" href="/Project/Menu/Menu.css">

</head>
<body>
		<!--horizontal bar !-->
<div class="navbar" id="navbar">
  		<a class="active" href="">Home</a>
       <!--not use!-->
  		<a href="../Project/Logout.php">Logout</a>
	</div>

		<!--horizontal bar !-->
		<!--Slide menu !-->
<div class="sidenav">
  <a class="active" href=""><h3>Admin</h3></a>
  <br>
  <a href="index.php?page=dashboard">แดชบอร์ด</a>
  <a href="index.php?page=customer">ลูกค้า</a>
  <a href="index.php?page=material">วัตถุดิบ</a>
  <a href="index.php?page=inventory">คลังสินค้า</a>
  <a href="index.php?page=product">สินค้า</a>
  <a href="index.php?page=productmodel">แบบผลิตภัณฑ์</a>
  <a href="index.php?page=staff">พนักงาน</a>
  <a href="index.php?page=sell">การขาย</a>
  <a href="index.php?page=delivery">จัดส่งสินค้า</a>
  <a href="index.php?page=defective">สินค้าชำรุด</a>
  <a href="index.php?page=manufacture">การผลิต</a>
  <a href="index.php?page=salary">เงินเดือนพนักงาน</a>
  <a href="index.php?page=finance">บัญชีการเงิน</a>
  <a href="index.php?page=repairmachine">ซ่อมเครื่องจักร</a>
</div>
		<!--End Slide menu !-->
		<!--Content!-->
<div class="main">
<?php
switch ($_GET["page"])
{
  //dashboard page//
  case "dashboard":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/dashboard.php");
    break;
    ////////////////////////////////////////////////////////
    //show customer data//
  case "customer":
    echo "<br>";
    include("./source/cus_list.php");
    break;
    ///edite customer form//
 case "cuseditForm":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/cusEditForm.php");
    break;
    //add new customer form//
  case "addnewCus":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/customer.php");
    break;
    ////////////////////////////////////////////////////////
    //list rawmaterial form
  case "material":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/rawMtr_list.php");
    break;
    //Edit raw material form//
    case "rawEditform":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/rawEditform.php");
    break;
    //End//
    //add new raw material//
    case "addnewrowMaterial":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/rawmaterial.php");
    break;
    //add new inventory form
   case "inventory":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/inventory.php");
    break;
    //add new product form
    case "product":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/product.php");
    break;
    //add new prototype form
    case "productmodel":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/productModel.php");
    break;
    //add new staff form
    case "staff":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/staff.php");
    break;
    //add new selling form
    case "sell":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/selling.php");
    break;
    //add new delivery form
    case "delivery":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/delivery.php");
    break;
    //add new defective form
    case "defective":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/productDefective.php");
    break;
    //add new manufature form
    case "manufacture":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/manufacture.php");
    break;
    //add new salary form
    case "salary":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/staff_salary.php");
    break;
    //add new finance form
    case "finance":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/account.php");
    break;
    //add new repair machine form
    case "repairmachine":
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    include("./source/machineMaintenance.php");
    break;
    



}
?>
</div>

<script>

       //script hide navbar when scroll
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-90px";
  }
  prevScrollpos = currentScrollPos;
}
</script>
</body>
</html>

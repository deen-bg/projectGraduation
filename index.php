<?php
session_start();
require_once("../Project/database/Db.php");   //require connect Db file//
$objDb = new Db();
$db = $objDb->database;
                //sission check//
if (empty($_SESSION['username']))
  header('Location: Form_login.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>index</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> <!--Set scale!-->
  
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <!--Set content & font!-->
	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.css">
			 <!--sidebar & navbar!-->
	<link rel="stylesheet" type="text/css" href="/Project/Menu/Menu.css">
  <link rel="stylesheet" type="text/css" href="/Project/CSS/list.css">
  <link rel="stylesheet" type="text/css" href="Project/fontawesome-free-5.3.1-web/fontawesome-free-5.3.1-web/css/fontawesome.css"> <!-- use Font aweasome.css!-->
  <link rel="stylesheet" type="text/css" href="/Project/fontawesome-free-5.3.1-web/fontawesome-free-5.3.1-web/css/all.min.css"> <!-- use Font aweasome.css!-->
    <script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
                        <!--Script no refresh page-->
    <script type="text/javascript" src="/Project/jquery/jquery.form.js"></script>
</head>
<body>
		<!--horizontal bar !-->
<div class="navbar" id="navbar">
  		<a class="active" href="">Home</a>
       <!--not use!-->
  		<a href="../Project/Logout.php">Logout</a>
	</div>
		<!--END horizontal bar !-->
   <?php
function active($current_page){
    $page = $_GET['page'];
    if(isset($page) && $page == $current_page){
        echo 'active'; //this is class name in css
    }
}
?>
<!--<li><a class="<?php// active('page1');?>" href="?p=page1">page1</a></li>
    <li><a class="<?php// active('page2');?>" href="?p=page2">page2</a></li>
		<!--Slide menu !-->
<div class="sidenav">
  <a class="active" href=""><h3>Admin</h3></a>
  <br>
  <a class="<?php active('dashboard');?>" href="index.php?page=dashboard">แดชบอร์ด</a>
  <a class="<?php active('customer');?>" href="index.php?page=customer">ลูกค้า</a>
  <a class="<?php active('material');?>" href="index.php?page=material">วัตถุดิบ</a>
 <!-- <a href="index.php?page=inventory">คลังสินค้า</a>-->
  <a class="<?php active('product');?>" href="index.php?page=product">สินค้า</a>
  <a class="<?php active('productmodel');?>" href="index.php?page=productmodel">แบบผลิตภัณฑ์</a>
  <button class="dropdown-btn" >ข้อมูลพนักงาน
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a class="<?php active('staff');?>" href="index.php?page=staff">พนักงาน</a>
    <a class="<?php active('salary');?>" href="index.php?page=salary">เงินเดือนพนักงาน</a>
    <a  class="<?php active('work');?>" href="index.php?page=work">การทำงาน</a>
  </div>
  <button class="dropdown-btn">ข้อมูลการขาย
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
     <a class="<?php active('sell');?>" href="index.php?page=sell">การขาย</a>
     <a class="<?php active('desc_sell');?>" href="index.php?page=desc_sell">รายละเอียด</a>
  </div>
  <button class="dropdown-btn">ข้อมูลจัดส่ง
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
     <a class="<?php active('delivery');?>" href="index.php?page=delivery">จัดส่งสินค้า</a>
     <a class="<?php active('');?>" href="#">รายละเอียด</a>
  </div>
  <a class="<?php active('defective');?>" href="index.php?page=defective">สินค้าชำรุด</a>
  <a class="<?php active('manufacture');?>" href="index.php?page=manufacture">การผลิต</a>
  <a class="<?php active('finance');?>" href="index.php?page=finance">บัญชีการเงิน</a>
  <a class="<?php active('repairmachine');?>" href="index.php?page=repairmachine">ซ่อมเครื่องจักร</a>
  <a class="<?php active('producttype');?>" href="index.php?page=producttype">ประเภทสินค้า</a>
  <br>
  <br>
</div>
		<!--End Slide menu !-->
		<!--Content!-->
<div class="main">
  <?php
//////////////////////////////////////check link use by swicth 'page' variable////////////////////////////////////////////
    switch ($_GET["page"])
    {
      //////////////////////////1.dashboard page///////////////////////////////////////////////////////////////////
      case "dashboard":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/dashboard.php");
        break;
        ////////////////////////END/////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////2.list customer////////////////////////////////////////////////////
      case "customer":
        echo "<br>";
        include("./source/cus_list.php");
        break;
        ///////////////////////////////////////////2.1 Edit customer form////////////////////////////////////////////
     case "cuseditForm":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/cusEditForm.php");
        break;
        ///////////////////////////////////////////2.2 add new customer form////////////////////////////////////////
      case "addnewCus":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/customer.php");
        break;
        ///////////////////////////////////////////2.3 Customer report/////////////////////////////////////////////
        case "Cusreport":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/cus_report.php");
        break;
        /////////////////////////////////////////3.list rawmaterial form////////////////////////////////////////
      case "material":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/rawMtr_list.php");
        break;
        ////////////////////////////////////////////3.1 Edit raw material form/////////////////////////////////
        case "rawEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/rawEditform.php");
        break;
        ////////////////////////////////////////////3.2 add new raw material/////////////////////////////////////
        case "addnewrowMaterial":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/rawmaterial.php");
        break;
        ////////////////////////////////////////////3.3 raw material report///////////////////////////////////
         case "rawMtr_report":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/rawMtr_report.php");
        break;
        ///////////////////////////////////////4.list inventory form//////////////////////////////////////////////
       case "inventory":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/invent_list.php");
        break;
        /////////////////////////////////////////4.1adnew inventory//////////////////////////////////////////////
        case "addnewrowInventory":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/inventory.php");
        break;
        /////////////////////////////////////////4.2 Edit inventory form////////////////////////////////////////
        case "inventEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/invent_Editform.php");
        break;
        /////////////////////////////////////5.list product table///////////////////////////////////////////////
        case "product":
        echo "<br>";
        echo "<br>";
        include("./source/product_list.php");
        break;
        ////////////////////////////////////////5.1 add new product////////////////////////////////////////////
        case "addnewProduct":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/product.php");
        break;
        ////////////////////////////////////////5.2Edit product/////////////////////////////////////////////
        case "productditForm":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/productEditform.php");
        break;
        ////////////////////////////////////////5.3 product report/////////////////////////////////////////
        case "product_report":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/product_report.php");
        break;
        ////////////////////////////////////6.list prototype form//////////////////////////////////////////////
        case "productmodel":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/productModel_list.php");
        break;
        ////////////////////////////////////////6.1 add new product Model//////////////////////////////////////
        case "addnewproductModel":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/productModel.php");
        break;
        ////////////////////////////////////////6.2Edit pModel//pmodelditForm/////////////////////////////////////
         case "pmodelditForm":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/pModelEditform.php");
        break;
        ///////////////////////////////////7. list staff form/////////////////////////////////////////////////////
        case "staff":
        echo "<br>";
        echo "<br>";
        include("./source/staff_list.php");
        break;
        //////////////////////////////////////7.1 add new staff////////////////////////////////////////////////////
        case "addnewStaff":
        echo "<br>";
        echo "<br>";
            echo "<br>";
        echo "<br>";
        include("./source/staff.php");
        break;
        /////////////////////////////////////7.2 Edit staff///////////////////////////////////////////////////////
        case "staffditForm":
        echo "<br>";
        echo "<br>";
        include("./source/staffEditform.php");
        break;
        /////////////////////////////////////7.3staff_report////////////////////////////////////////////////////
         case "staff_report":
        echo "<br>";
        echo "<br>";
        include("./source/staff_report.php");
        break;
        ///////////////////////////////8. list selling form/////////////////////////////////////////////////////
        case "sell":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/sell_list.php");
        break;
        ////////////////////////////////////8.1 and new selling//////////////////////////////////////////////////
        case "addnewrowSell":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/selling.php");
        break;
        ////////////////////////////////////8.2 sell Edit///////////////////////////////////////////////////////
        case "sellEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/sellEditform.php");
        break;
        /////////////////////////////////////8.3 sell desc////////////////////////////////////////////////////
        case "sellDesc":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/sell_descs.php");
        break;
        /////////////////////////////////////8.4 sell_descs_report///////////////////////////////////
        case "sell_desc_report":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/sell_desc_report.php");
        /////////////////////////////////////////9. list delivery form//////////////////////////////////////////
        case "delivery":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/delivery_list.php");
        break;
        ///////////////////////////////////////////9.1 add new delivery////////////////////////////////////////
        case "addnewDelivery":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/delivery.php");
        break;
        ///////////////////////////////////////////9.2 Edit delivery form///////////////////////////////////////
        case "deliveryEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/deliverEditform.php");
        break;
        /////////////////////////////////////10. list defective form///////////////////////////////////////////
        case "defective":
        echo "<br>";
        echo "<br>";
        include("./source/defective_list.php");
        break;
        ////////////////////////////////////////10.1 add new defective product///////////////////////////////////
        case "addnewDefective":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/productDefective.php");
        break;
        /////////////////////////////////////////10.2 Edit defective product/////////////////////////////////////
        case "defectiveEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/defectiveEditform.php");
        break;
        ////////////////////////////////////////////11. list manufature form////////////////////////////////////////
        case "manufacture":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/manufac_list.php");
        break;
        ////////////////////////////////////////////////11.1 Add new manufacture//////////////////////////////////
         case "addnewrowManufac":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/manufacture.php");
        break;
        ///////////////////////////////////////////////11.2 Edit manufacture/////////////////////////////////////////
        case "manufacEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/manufacEditform.php");
        break;
        ///////////////////////////////////////////11.3 manufacDesc///////////////
         case "manufacDesc":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/manufacDesc.php");
        break;
        ////////////////////////12. list payroll staff salary form//////////////
        case "salary":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/staffsalary_list.php");
        break;
        /////////////////////////////////////////////12.1 add new payroll staff salary//////////////////////////////
        case "addnewstaffsalry":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/staff_salary.php");
        break;
        /////////////////////////////////////////////12.2 Edit payroll staff salary/////////////////////////////////
        case "salaryEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/slaryEditform.php");
        break;
        /////////////////////////////////////////////12.3 report payroll staff//
        case "staffsalary_report":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/salary_report.php");
        break;
        ///////////////////////////////////List work form///////////////////////////////////////////////////////////
        case "work":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/work_list.php");
        break;
        //////////////////////////////////END/////////////////////////////////////////////////////////////////
        ////////////////////Add new working///////////////////////////////
        case "addnewwork":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/work.php");
        break;
        //////////////////////END///////////////////////////////////////
        ///////////Edit working//////////////////////
        case "workEditform":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/workEditform.php");
        break;
        ///////////////////////////////work report///////////////
         case "work_report":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/work_report.php");
        break;
        ///////////////////////////////////////13. list account form///////////////////////////////////////////////////
        case "finance":
        echo "<br>";
        echo "<br>";
        include("./source/account_list.php");
        break;
        ///////////////////////////////////////////13.1 add new account//////////////////////////////////////////////
        case "addnewAccount":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/Account.php");
        break;
        ////////////////////////////////////////////13.2 Edit accont//////////////////////////////////////////////
        case "accountditForm":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/accountEditform.php");
        break;
        //////////////Account report///////////////////////////////
        case "accountReport":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/account_report.php");
        break;
        //////////////////////////////////////14. list repair machine form//////////////////////////////////////
        case "repairmachine":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/machineMtn_list.php");
        break;
        ////////////////////////////////////////////14.1 add new repair machine////////////////////////////////////////
        case "addnewmachineMaintenance":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/machineMaintenance.php");
        break;
        ////////////////////////////////////////////14.2 Edit machine form////////////////////////////////////////////
        case "machineMtneditForm":
        echo "<br>";
        echo "<br>";
        include("./source/machinesEditform.php");
        break;
        /////////////////////////////////////////////14.3 machineRepair
        case "machineHistoryForm":
        echo "<br>";
        echo "<br>";
        include("./source/machinesHistory.php");
        break;
        /////////////////////////////////////////////14.4 machine desc histry
         case "mch_DescHistory":
        echo "<br>";
        echo "<br>";
        include("./source/desc_history.php");
        break;
        //////////////////////////////////////////////15.product type///////////////////////////////////////////////
        case "producttype":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/product_type.php");
        break;
        //////////////////////////desccription sell//////////////////////////////////////
        case "desc_sell":
        echo "<br>";
        echo "<br>";
        include("./source/desc_sell.php");
        break;
        //////////////////////add new descsell form/////////////////////////
        case "addnewdescsell":
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        include("./source/desc_sellform.php");
        break;
        ////////////////////////END////////////////////////////////////
    }
  ?>
</div>
          <!--script hide navbar when scroll-->
<script>
  var prevScrollpos = window.pageYOffset;
  window.onscroll = function() 
  {
    var currentScrollPos = window.pageYOffset;
      if (prevScrollpos > currentScrollPos) 
      {
        document.getElementById("navbar").style.top = "0";
      } 
      else 
      {
        document.getElementById("navbar").style.top = "-90px";
      }
    prevScrollpos = currentScrollPos;
  }
</script>

<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
</body>
</html>

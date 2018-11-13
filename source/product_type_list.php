<?php
//session_start();

require_once("../Project/database/Db.php"); //require connect Db file//
$objDb = new Db();
$db = $objDb->database;
//////////////////////////////////////search////////////////////////
$search= '';      //Search//
if (isset($_POST['varsearch'])) 
{
  $varsearch = $_POST['varsearch'];
  $search = " WHERE `producttype_name` LIKE '%$varsearch%'";
}
/////////////////////////////////////////////////////////////////////////////////////////////
                    //Select table customer for Serach//
$sql = "SELECT * FROM producttype $search";
$stmt = $db->prepare($sql);
$stmt->execute();
////////////////////END/////////////////////////////////////////////////////////////////////////////

/*/////////////////////////////////Select for Show data///////////////////////////////////////////////
$sql = "SELECT * FROM producttype";      //Select table customer//
$stmt = $db->prepare($sql);          //prepare statment $sql//

    ///bind variable from customer table for variable in php
$stmt->bindParam(":producttype_id", $producttype_id, PDO::PARAM_INT);
$stmt->bindParam(":producttype_name", $producttype_name, PDO::PARAM_STR);

$result = $stmt->execute(array(':producttype_id'=>$producttype_id, ':producttype_name'=>$producttype_name)); //5
////////////////////////////END//////////////////////////////////////////////////////////////////////*/

?>
<!DOCTYPE html>
<html>
<head>
  <title>show data product type</title>
</head>
  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลประเภทสินค้า</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
    <form class="form-inline" action="index.php?page=producttype" method="post" >
        <input class="form-control" type="text" name="varsearch" value="<?php 
        if(isset($_POST['varsearch'])){echo $_POST['varsearch'];}

        ?>" placeholder="ค้นหาด้วยชื่อประเภท" aria-label="Search">&nbsp;
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">ค้นหา</button>
      </form>
  </div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
			<a href="index.php?page=Addnewproducttype"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่ม
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
          <th>ชื่อประเภทสินค้า</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->producttype_name ?></td>
          <td>
              <a href="index.php?page=producttypeEditform&producttype_id=<?= $row->producttype_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</a></button></td>
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
            data    : {'datapdtype' : dataArr},
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

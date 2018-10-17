<?php
//session_start();
ob_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$varsearch = '';
$query = "SELECT * FROM productmodel WHERE pmodel_name LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', '%' . $varsearch . '%', PDO::PARAM_INT);
$stmt->execute();

$sql = "SELECT * FROM productmodel";
$stmt = $db->prepare($sql);

		///bind variable from customer table  to variable in php
$stmt->bindParam(":pmodel_id", $pmodel_id, PDO::PARAM_INT);
$stmt->bindParam(":pmodel_name", $pmodel_name, PDO::PARAM_STR);
$stmt->bindParam(":pmodel_desc", $pmodel_desc, PDO::PARAM_STR);
$stmt->bindParam(":pmodel_img", $pmodel_img, PDO::PARAM_STR);
$stmt->execute();  //execute statatement

$result = $stmt->execute(array(':pmodel_id'=>$pmodel_id, 
	':pmodel_name'=>$pmodel_name, ':pmodel_desc'=>$pmodel_desc, 
	':pmodel_img'=>$pmodel_img)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data Product Model</title>
</head>
  <style>
  /***************************Modal img full screen********************************/
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Add Animation */
.modal-content {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
  /***************************END******************************/
  </style>
  <body>
<div class="main">
    		<br>
    		<br>
    		<b><h3>ข้อมูลแบบผลิตภัณฑ์</h3></b>
    		<br>
    		<br>
  <div class="row">
  	<div class="col-8">
  		<form class="form-inline" action="../Project/source/cus_list.php" method="get" >
  		    <input class="form-control" type="text" name="varsearch" value="<?php echo $varsearch ?>" placeholder="ค้นหาด้วยรหัสลูกค้า" aria-label="Search">&nbsp;
  		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
    		</form>
  	</div>
  	<div class="col-sm-4" align="right">
  		<div class="btn-group">
         <a href=""><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;ออกรายงาน</button></a>&nbsp;
  			<a href="index.php?page=addnewproductModel"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md"><i class="fa fa-plus-square" aria-hidden="true"></i></i>&nbsp;เพิ่มแบบผลิตภัณฑ์
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
            <th>รหัสแบบผลิตภัณฑ์</th>
            <th>ชื่อแบบ</th>
            <th>รายละเอียด</th>
            <th>ภาพ</th>
            <th>จัดการข้อมูล</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
          <tr>
            <td><?php echo $row->pmodel_id ?></td>
            <td><?php echo $row->pmodel_name ?></td>
            <td><?php echo $row->pmodel_desc ?></td>
            <td><img src="../Project/imgUpload/<?php echo $row->pmodel_img;?>" alt=" " height="75" width="75" id="myImg"><br><?php echo $row->pmodel_img ?></td>
            <td> <a href="" style="text-decoration:none">ดู</a> |
                <a href="index.php?page=pmodelditForm&pmodel_id=<?= $row->pmodel_id; ?>" style="text-decoration:none; color: #ffffff;"><button class="btn btn-info"><i class="fa fa-wrench" aria-hidden="true"></i>แก้ไข</a></button> |
                <a href="./source/edit.php?page=pmodelditForm&pmodel_id=<?= $row->pmodel_id; ?>" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>ลบ</button></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
  </div>

<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}
</script>


</div>
  </body>
</html>
<<?php ob_end_flush(); ?>
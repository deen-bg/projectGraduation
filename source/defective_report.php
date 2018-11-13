<?php
ob_start();
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

$sql = "SELECT defective.*, product.product_id, product.product_name 
FROM defective 
INNER JOIN product ON defective.pddefective_fid = product.product_id 
ORDER BY defective.defective_id";

$stmt = $db->prepare($sql);
    ///bind variable from customer table  to variable in php
$stmt->bindParam(":defective_id", $defective_id, PDO::PARAM_INT);
$stmt->bindParam(":defective_date", $defective_date, PDO::PARAM_INT);
$stmt->bindParam(":defective_amount", $defective_amount, PDO::PARAM_STR);
$stmt->bindParam(":defective_total", $defective_total, PDO::PARAM_STR);
$result = $stmt->execute(array(':defective_id'=>$defective_id, 
  ':defective_amount'=>$defective_amount, ':defective_total'=>$defective_total)); //5

	$table="";
	$table .= "

	<table align='center' style='width:100%;' >
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 10%'>ลำดับ</th>
	          <th style='width: 15%'>วันที่</th>
	          <th style='width: 35%'>ชื่อสิ้นคา</th>
	          <th style='width: 20%'>จำนวน/ชิ้น</th>
	          <th style='width: 20%'>ค่าเสียหาย/THB.</th>
	        </tr>
	    </thead>
	</table>
	";
ob_end_clean();
////////////////////////////////mPDF run class/////////////////////////////////////////
	$mpdf = new \Mpdf\Mpdf([
		'default_font_size' => 14,
		'default_font' => 'sarabun'
	]);

	$mpdf->setAutoTopMargin = 'stretch';			//Set margin = Auto stretch//
	$html = ob_get_contents();
	$mpdf->SetHeader('ระบบจัดการโรงงสนผลิตเซรามิค||{PAGENO}');	//Set header page//
	$mpdf->defaultheaderline=0;											//Set header line//
	$mpdf->defaultheaderfontsize=16;									//Set header font size//
	$mpdf->defaultheaderfontstyle='B';									//Set header font style//
	//END//
	//Set footer//
	$mpdf->defaultfooterfontsize=10;							//Set footer font size//
	$mpdf->defaultfooterfontstyle='BI';							//Set footer font style//
	$mpdf->defaultfooterline=0;									//Set footer line
	//END//
	$mpdf->WriteHTML('<p style="border:1" width="30%">&nbsp;<b>โรงงานผลิตเซรามิค บ.เซรามิค จำกัด</b><br>&nbsp;<b>ที่อยู่:</b> 1/118 <b>ต</b>.รูสะมิแล <b>อ</b>.เมือง <b>&nbsp;จ</b>.ปัตตานี 94000</p>');	//write topic//
	$mpdf->WriteHTML('<h2 style="text-align: center">รายงานข้อมูลสินค้าชำรุด</h2></center>');	//write topic//
	$mpdf->WriteHTML("<hr>");														//write horizonetal line//
	$mpdf->WriteHTML($table);														//write table head// by variable//
	$mpdf->shrink_tables_to_fit = 1;												//Set to fit paper//

	$num_row= 0; //New variable use count row//
	$total =0;     //รวมยอดทั้งหมด
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$num_row++;   //row +1;
		$sumeachTotal= $row->defective_total;
        $total = $sumeachTotal + $total;
								//loop table row//
	    $mpdf->WriteHTML("<table border='0' width='100%' font='16px' style='font-size: 14pt;'>");
		$mpdf->WriteHTML("<tr style='border:1'>
							<td style='width: 10%'>$num_row</td>
							<td style='width: 15%'>$row->defective_date</td>
							<td style='width: 35%'>$row->product_name</td>
		    				<td style='width: 20%'>$row->defective_amount</td>
		    				<td style='width: 20%'>$row->defective_total</td>
		    			</tr>");
		$mpdf->WriteHTML("</table>");
	}
	//END loop table//
	$mpdf->WriteHTML("<hr>");
	$mpdf->WriteHTML('จำนวนรายการ : </b>'.$num_row .'&nbsp;รายการ<br>');
	$mpdf->WriteHTML('<b>ยอดรวมสุทธิ : </b>'.$total.'&nbsp;<b>บาท');
	$mpdf->WriteHTML("<hr>");
//////////////////////////////footer//////////////////////////////////////
/*::footer details
	-Day-month-year
	-page No.
	-Description
*/
	$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%">วันที่ : {DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">รายงานข้อมูลสินค้าชำรุด</td>
    </tr>
</table>');
//////////////////////////////END footer///////////////////////////////////////
//following from above...Add page
$mpdf->AddPage();

$arr['L']['content'] = 'Chapter 2';
$mpdf->SetHeader($arr, 'O');
//END//
	$mpdf->Output();
	exit();


?>
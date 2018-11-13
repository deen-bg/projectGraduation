<?php
ob_start();
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

$manufac_id = $_GET['manufac_id'];
$sql = "SELECT manufacture.*, product.product_id, product.product_name, desc_manufac.descmnf_fid, 
desc_manufac.descmtr_fid, desc_manufac.manufac_QtyrMtr, rawmaterial.matr_name 
FROM manufacture 
INNER JOIN product ON manufacture.manufac_pfid = product.product_id 
INNER JOIN desc_manufac ON manufacture.manufac_id = desc_manufac.descmnf_fid 
INNER JOIN rawmaterial ON desc_manufac.descmtr_fid = rawmaterial.matr_id
WHERE manufac_id=:manufac_id
ORDER BY manufacture.manufac_id ";
$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute([':manufac_id' => $manufac_id]);

$stmt2 = $db->prepare($sql);//prepare data after select//
$stmt2->execute([':manufac_id' => $manufac_id]);

	$table="";
	$table .= "

	<table align='center' style='width:100%;' border='1'>
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 5%'>ลำดับ</th>
	          <th style='width: 15%'>วันที่ผลิต</th>
	          <th style='width: 30%'>ชื่อสินค้า</th>
	          <th style='width: 30%'>วัตถุดิบที่ใช้</th>
	          <th style='width: 20%'>ปริมาณ/หน่วย</th>
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
	$mpdf->WriteHTML('<p style="border:1" width="30%">&nbsp;<b>โรงงานผลิตเซรามิค บ.เซรามิค จำกัด</b><br>&nbsp;<b>ที่อยู่:</b> 1/118 <b>ต</b>.รูสะมิแล <b>อ</b>.เมือง <b>จ</b>.ปัตตานี 94000</p>');	//write topic//
	$mpdf->WriteHTML('<h3 style="text-align: center">ใบแจ้งวัตถุดิบที่ใช้ในการผลิต</h3></center>');	//write topic//
	

	$round2 = true;
	while($rows = $stmt2->fetch(PDO::FETCH_OBJ))
	{
		if ($round2)
		{
			$mpdf->WriteHTML("<b>สินค้าที่สั่งผลิต</b> :&nbsp;&nbsp;$rows->product_name&nbsp;<br>
				<b>จำนวนที่สั่งผลิต:</b> :&nbsp;&nbsp;$rows->manufac_ordered");
			$round2 = false;
		}
		else
            {
            	$mpdf->WriteHTML("");
            }

	}


	$mpdf->WriteHTML("<hr>");	
														//write horizonetal line//
	$mpdf->WriteHTML($table);														//write table head// by variable//
	$mpdf->shrink_tables_to_fit = 1;												//Set to fit paper//

	$num_row= 0; //New variable use count row//
	 $total =0;     //รวมยอดทั้งหมด
	$round = true;
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$num_row++;   //row +1;
		/*  $sumeachTotal= $row->sell_total;
          $total = $sumeachTotal + $total;*/
        if ($round)
        {
								//loop table row//
		    $mpdf->WriteHTML("<table border='0' width='100%' font='16px' style='font-size: 14pt;'>");
			$mpdf->WriteHTML("<tr style='border:1'>
								<td style='width: 5%'>$num_row</td>
			    				<td style='width: 15%'>$row->manufac_date</td>
			    				<td style='width: 30%'>$row->product_name</td>
			    				<td style='width: 30%'>$row->matr_name</td>
			    				<td style='width: 20%'>$row->manufac_QtyrMtr</td>
			    			</tr>");
			$mpdf->WriteHTML("</table>");
			$round = false;
		}
		else
            {
            $mpdf->WriteHTML("<table border='0' width='100%' font='16px' style='font-size: 14pt;'>");
			$mpdf->WriteHTML("<tr style='border:1'>
								<td style='width: 5%'>$num_row</td>
			    				<td style='width: 15%'></td>
			    				<td style='width: 30%'></td>
			    				<td style='width: 30%'>$row->matr_name</td>
			    				<td style='width: 20%'>$row->manufac_QtyrMtr</td>
			    			</tr>");
			$mpdf->WriteHTML("</table>");
            }
	}
	//END loop table//
	$mpdf->WriteHTML("<hr>");
	$mpdf->WriteHTML('จำนวนรายการวัตถุดิบ : </b>'.$num_row .'&nbsp;รายการ<br>');
	/*$mpdf->WriteHTML('<b>ยอดรวมสุทธิ : </b>'.$total.'&nbsp;<b>บาท');*/
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
        <td width="33%" style="text-align: right;">ใบแจ้งวัตถุดิบที่ใช้ในการผลิต</td>
    </tr>
</table>');
//////////////////////////////END footer///////////////////////////////////////
//following from above...Add page
/*$mpdf->AddPage();

$arr['L']['content'] = 'Chapter 2';
$mpdf->SetHeader($arr, 'O');*/
//END//
	$mpdf->Output();
	exit();


?>
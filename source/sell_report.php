<?php
ob_start();
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

	$sql = "SELECT sell.*, customer.cus_id, customer.cus_name 
FROM sell 
INNER JOIN customer ON sell.cus_fid = customer.cus_id 
WHERE NOT sell_status='ยกเลิก'
ORDER BY sell.sell_id";

$stmt = $db->prepare($sql);//prepare data after select//
		
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);  //bind parameter = การแทนที่ตัวแปรใน statement เพื่อประมวลผลต่างๆ
$stmt->bindParam(":sell_date", $sell_date, PDO::PARAM_STR);
$stmt->bindParam(":sell_status", $sell_status, PDO::PARAM_STR);

$result = $stmt->execute(array(':sell_id'=>$sell_id, 
	':sell_date'=>$sell_date, ':sell_status'=>$sell_status)); //5

	$table="";
	$table .= "

	<table align='center' style='width:100%;' >
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 10%'>ลำดับ</th>
	          <th style='width: 40%'>ชื่อลูกค้า</th>
	          <th style='width: 30%'>วันที่ขาย</th>
	          <th style='width: 20%'>สถานะ</th>
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
	$mpdf->WriteHTML('<h2 style="text-align: center">ข้อมูลการขาย</h2></center>');	//write topic//
	$mpdf->WriteHTML("<hr>");														//write horizonetal line//
	$mpdf->WriteHTML($table);														//write table head// by variable//
	$mpdf->shrink_tables_to_fit = 1;												//Set to fit paper//

	$num_row= 0; //New variable use count row//
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$num_row++;   //row +1;
								//loop table row//
	    $mpdf->WriteHTML("<table border='0' width='100%' font='16px' style='font-size: 14pt;'>");
		$mpdf->WriteHTML("<tr style='border:1'>
							<td style='width: 10%'>$num_row</td>
							<td style='width: 40%'>$row->cus_name</td>
		    				<td style='width: 30%'>$row->sell_date</td>
		    				<td style='width: 20%'>$row->sell_status</td>
		    			</tr>");
		$mpdf->WriteHTML("</table>");
	}
	//END loop table//
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
        <td width="33%" style="text-align: right;">รายงานข้อมูลการขาย</td>
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
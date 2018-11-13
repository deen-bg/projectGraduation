<?php
ob_start();
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

	$sql = "SELECT * FROM customer";		//Select table
	$stmt = $db->prepare($sql);

	///bind variable from customer table  to variable in php//
	$stmt->bindParam(":cus_id", $cus_id, PDO::PARAM_INT);
	$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
	$stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
	$stmt->bindParam(":gen_radio", $gen_radio, PDO::PARAM_STR);
	$stmt->bindParam(":cus_mail", $cus_mail, PDO::PARAM_STR);
	$stmt->bindParam(":cus_phone", $cus_phone, PDO::PARAM_STR);
	$stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);

	$stmt->execute();  ////execute statatement
	$result = $stmt->execute(array(':cus_id'=>$cus_id, 
		':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
		':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
		':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add));

	$table="";
	$table .= "

	<table align='center' style='width:100%;' >
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 10%'>ลำดับ</th>
	          <th style='width: 20%'>ชื่อลูกค้า</th>
	          <th style='width: 20%'>นามสกุล</th>
	          <th style='width: 10%'>เพศ</th>
	          <th style='width: 30%'>อีเมล์</th>
	          <th style='width: 10%'>เบอร์โทร</th>
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
	$mpdf->WriteHTML('<h2 style="text-align: center">ใบรายงานรายชื่อลูกค้า</h2></center>');	//write topic//
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
							<td style='width: 20%'>$row->cus_name</td>
							<td style='width: 20%'>$row->cus_surname</td>
		    				<td style='width: 10%'>$row->cus_gender</td>
		    				<td style='width: 30%'>$row->cus_mail</td>
		    				<td style='width: 10%'>$row->cus_phone</td>
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
        <td width="33%" style="text-align: right;">รายงานข้อมูลลูกค้า</td>
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
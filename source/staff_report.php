<?php
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

	$sql = "SELECT * FROM staff";		//Select table
	$stmt = $db->prepare($sql);

	///bind variable from customer table  to variable in php//
	$stmt->bindParam(":staff_id", $staff_id, PDO::PARAM_INT);
	$stmt->bindParam(":staff_name", $staff_name, PDO::PARAM_STR);
	$stmt->bindParam(":staff_surname", $staff_surname, PDO::PARAM_STR);
	$stmt->bindParam(":staff_passportid", $staff_passportid, PDO::PARAM_STR);
	$stmt->bindParam(":staff_add", $staff_add, PDO::PARAM_STR);
	$stmt->bindParam(":staff_stwd", $staff_stwd, PDO::PARAM_STR);
	$stmt->bindParam(":staff_phone", $staff_phone, PDO::PARAM_STR);

	
$stmt->execute();  //execute statatement

$result = $stmt->execute(array(':staff_id'=>$staff_id, 
	':staff_name'=>$staff_name, ':staff_surname'=>$staff_surname, 
	':staff_passportid'=>$staff_passportid, ':staff_add'=>$staff_add,
	':staff_stwd'=>$staff_stwd, ':staff_phone'=>$staff_phone)); //5

	//$table="";
	$table .= "

	<table align='center' style='width:100%;' >
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 5%'>ลำดับ</th>
	          <th style='width: 20%'>ชื่อ</th>
	          <th style='width: 15%'>นามสกุล</th>
	          <th style='width: 20%'>เลขบัตรประชาชน</th>
	          <th style='width: 25%'>ที่อยู่</th>
	          <th style='width: 15%'>เบอร์โทร</th>
	        </tr>
	    </thead>
	</table>
	";
////////////////////////////////mPDF run class/////////////////////////////////////////
	$mpdf = new \Mpdf\Mpdf([
		'default_font_size' => 14,
		'default_font' => 'sarabun'
	]);

	$mpdf->setAutoTopMargin = 'stretch';			//Set margin = Auto stretch//
	$mpdf->SetHeader('ระบบจัดการโรงงานผลิตเซรามิค||{PAGENO}');	//Set header page//
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
	$mpdf->WriteHTML('<h2 style="text-align: center">ข้อมูลรายชื่อพนักงาน</h2></center>');	//write topic//
	$mpdf->WriteHTML("<hr>");														//write horizonetal line//
	$mpdf->WriteHTML($table);

	$html = ob_get_contents();														//write table head// by variable//
	$mpdf->shrink_tables_to_fit = 1;												//Set to fit paper//

	$num_row= 0; //New variable use count row//
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$num_row++;   //row +1;
								//loop table row//
	    $mpdf->WriteHTML("<table border='0' width='100%' font='16px' style='font-size: 14pt;'>");
		$mpdf->WriteHTML("<tr style='border:0'>
							<td style='width: 10%'>$num_row</td>
							<td style='width: 20%'>$row->staff_name</td>
							<td style='width: 15%'>$row->staff_surname</td>
		    				<td style='width: 20%'>$row->staff_passportid</td>
		    				<td style='width: 25%'>$row->staff_add</td>
		    				<td style='width: 15%'>$row->staff_phone</td>
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
        <td width="33%" style="text-align: right;">รายงานรายชื่อพนักงาน</td>
    </tr>
</table>');
//////////////////////////////END footer///////////////////////////////////////
//following from above...Add page
$mpdf->AddPage();

$arr['L']['content'] = 'Chapter 2';
$mpdf->SetHeader($arr, 'O');
//END//
	$mpdf->Output();
		// Buffer the following html with PHP so we can store it to a variable later
ob_start();
ob_end_clean();
	exit();
?>
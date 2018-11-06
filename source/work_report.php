<?php
ob_start();
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

$sql = "SELECT work.*, staff.staff_name, staff.staff_id 
FROM work 
INNER JOIN staff ON work.staff_fid = staff.staff_id ORDER BY work.work_id";
//$sql = "SELECT * FROM work";
$stmt = $db->prepare($sql);

    ///bind variable from customer table  to variable in php
$stmt->bindParam(":work_id", $work_id, PDO::PARAM_INT);
$stmt->bindParam(":work_date", $work_date, PDO::PARAM_STR);
$stmt->bindParam(":work_dayoff", $work_dayoff, PDO::PARAM_STR);
$stmt->bindParam(":work_time", $work_time, PDO::PARAM_STR);

$stmt->execute();  //execute statatement
$result = $stmt->execute(array(':work_id'=>$work_id, 
	':work_date'=>$work_date, ':work_dayoff'=>$work_dayoff, 
	':work_time'=>$work_time)); //5
	$table="";
	$table .= "

	<table align='center' style='width:100%;'>
	      <thead style='border:1' >
	        <tr style='background:grey;' >
	          <th style='width: 10%'>ลำดับ</th>
	          <th style='width: 20%'>ชื่อพนักงาน</th>
	          <th style='width: 20%'>วันที่ทำงาน</th>
	          <th style='width: 20%'>จำนวนวันลางาน</th>
	          <th style='width: 20%'>เวลาเข้างาน</th>
	        </tr>
	    </thead>
	</table>
	";
ob_end_clean();
////////////////////////////////mPDF run class/////////////////////////////////////////
	$mpdf = new \Mpdf\Mpdf([
		'default_font_size' => 16,
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
	$mpdf->WriteHTML('<h2 style="text-align: center">ข้อมูลการทำงาน</h2></center>');	//write topic//
	$mpdf->WriteHTML("<hr>");														//write horizonetal line//
	$mpdf->WriteHTML($table);														//write table head// by variable//
	$mpdf->shrink_tables_to_fit = 1;												//Set to fit paper//

	$num_row= 0; //New variable use count row//
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$num_row++;   //row +1;
								//loop table row//
	    $mpdf->WriteHTML("<table style='border-collapse: collapse;' style='border:1' width='100%' font='16px' style='font-size: 14pt;' >");
		$mpdf->WriteHTML("<tr style='border:1'>
							<td style='width: 10%'>$num_row</td>
							<td style='width: 20%'>$row->staff_name</td>
							<td style='width: 20%'>$row->work_date</td>
		    				<td style='width: 20%'>$row->work_dayoff</td>
		    				<td style='width: 20%'>$row->work_time</td>
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
        <td width="33%" style="text-align: right;">รายงานข้อมูลการทำงาน</td>
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
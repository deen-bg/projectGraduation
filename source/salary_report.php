<?php
ob_start();
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

$sql = "SELECT payrollstaff.*, staff.staff_name, staff.staff_id 
FROM payrollstaff 
INNER JOIN staff ON payrollstaff.staffsalary_fid = staff.staff_id 
ORDER BY payrollstaff.salary_id";
//$sql = "SELECT * FROM payrollstaff";

$stmt = $db->prepare($sql);//prepare data after select//
    ///convert column names from tables in database. is a php variable
$stmt->bindParam(":salary_id", $salary_id, PDO::PARAM_INT);
$stmt->bindParam(":salary_paydate", $salary_paydate, PDO::PARAM_STR);
$stmt->bindParam(":salary_payroll", $salary_payroll, PDO::PARAM_INT);
$stmt->bindParam(":salary_status", $salary_status, PDO::PARAM_STR);
$stmt->bindParam(":salary_ovtWdr", $salary_ovtWdr, PDO::PARAM_INT);
$stmt->bindParam(":salary_receiveAm", $salary_receiveAm, PDO::PARAM_INT);
$stmt->bindParam(":salary_total", $salary_total, PDO::PARAM_INT);

$result = $stmt->execute(array(':salary_id'=>$salary_id, 
	':salary_paydate'=>$salary_paydate, ':salary_payroll'=>$salary_payroll, 
	':salary_status'=>$salary_status, ':salary_ovtWdr'=>$salary_ovtWdr, ':salary_receiveAm'=>$salary_receiveAm,
  ':salary_total'=>$salary_total)); //5
	$table="";
	$table .= "

	<table align='center' style='width:100%;' >
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 5%'>ลำดับ</th>
	          <th style='width: 25%'>ชื่อพนักงาน</th>
	          <th style='width: 15%'>วันที่จ่ายเงิน</th>
	          <th style='width: 15%'>ค่าจ้าง/THB.</th>
	          <th style='width: 20%'>เบิกล่วงหน้า/THB.</th>
	          <th style='width: 10%'>ยอดรวม/THB.</th>
	          <th style='width: 10%'>สถานะ</th>
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
	$mpdf->WriteHTML('<h2 style="text-align: center">ข้อมูลการเบิกจ่ายเงินเดือนพนักงาน</h2></center>');	//write topic//
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
							<td style='width: 5%'>$num_row</td>
							<td style='width: 25%'>$row->staff_name</td>
							<td style='width: 15%'>$row->salary_paydate</td>
		    				<td style='width: 15%'>$row->salary_payroll</td>
		    				<td style='width: 20%'>$row->salary_ovtWdr</td>
		    				<td style='width: 10%'>$row->salary_total</td>
		    				<td style='width: 10%'>$row->salary_status</td>
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
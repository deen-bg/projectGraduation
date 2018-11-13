<?php
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

	$sql = "SELECT * FROM account WHERE account_itemtype='รายรับ'";		//Select table
	$stmt = $db->prepare($sql);

	///bind variable from customer table  to variable in php//
	$stmt->bindParam(":account_id", $account_id, PDO::PARAM_INT);
	$stmt->bindParam(":account_date", $account_date, PDO::PARAM_STR);
	$stmt->bindParam(":account_year", $account_year, PDO::PARAM_STR);
	$stmt->bindParam(":account_desc", $account_desc, PDO::PARAM_STR);
	$stmt->bindParam(":account_itemtype", $account_itemtype, PDO::PARAM_STR);
	$stmt->bindParam(":account_total", $account_total, PDO::PARAM_STR);

	$stmt->execute();  ////execute statatement
	$result = $stmt->execute(array(':account_id'=>$account_id, 
		':account_date'=>$account_date, ':account_year'=>$account_year, 
		':account_desc'=>$account_desc, ':account_itemtype'=>$account_itemtype,
		':account_total'=>$account_total));

	//$table="";
	$table .= "

	<table align='center' style='width:100%;' >
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 5%'>ลำดับ</th>
	          <th style='width: 15%'>วันที่</th>
	          <th style='width: 40%'>รายการ</th>
	          <th style='width: 10%'>ประเภท</th>
	          <th style='width: 20%'>ยอดรวมTHB.</th>
	        </tr>
	    </thead>
	</table>
	";
	/////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////mPDF run class/////////////////////////////////////////
	$mpdf = new \Mpdf\Mpdf([
		'default_font_size' => 14,
		'default_font' => 'sarabun'
	]);

	$mpdf->setAutoTopMargin = 'stretch';			//Set margin = Auto stretch//
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
	$mpdf->WriteHTML('<h3 style="text-align: center">ข้อมูลรายรับ</h3></center>');	//write topic//
	$mpdf->WriteHTML("<hr>");														//write horizonetal line//
	$mpdf->WriteHTML($table);

	$html = ob_get_contents();														//write table head// by variable//
	$mpdf->shrink_tables_to_fit = 1;												//Set to fit paper//

	$num_row= 0; //New variable use count row//
	 $total =0;     //
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$num_row++;   //row +1;
		 $sumeachTotal= $row->account_total;
          $total = $sumeachTotal + $total;
								//loop table row//
	    $mpdf->WriteHTML("<table border='0' width='100%' font='16px' style='font-size: 14pt;'>");
		$mpdf->WriteHTML("<tr style='border:0'>
							<td style='width: 5%'>$num_row</td>
							<td style='width: 15%'>$row->account_date</td>
		    				<td style='width: 40%'>$row->account_desc</td>
		    				<td style='width: 10%'>$row->account_itemtype</td>
		    				<td style='width: 20%'>$row->account_total</td>
		    			</tr>");
		$mpdf->WriteHTML("</table>");
	}
	//END loop table//
	$mpdf->WriteHTML("<hr>");
	$mpdf->WriteHTML('จำนวนรายการ : </b>'.$num_row .'&nbsp;รายการ<br>');
	$mpdf->WriteHTML('<b>สรุปรายรับ : </b>'.$total.'&nbsp;<b>บาท');
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
        <td width="33%" style="text-align: right;">รายงานบัญชีรายรับ-รายจ่าย</td>
    </tr>
</table>');
//////////////////////////////END footer///////////////////////////////////////
//following from above...Add page
/*$mpdf->AddPage();

$arr['L']['content'] = 'Chapter 2';
$mpdf->SetHeader($arr, 'O');*/
//END//
	$mpdf->Output();
		// Buffer the following html with PHP so we can store it to a variable later
ob_start();
ob_end_clean();
	exit();
?>
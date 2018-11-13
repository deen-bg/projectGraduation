<?php
ob_start();
require_once("../Project/database/Db.php");   //rquire connect Db file//
$objDb = new Db();
$db = $objDb->database;

require_once("../Project/mpdf_mpdf_7.1.5.0_require/vendor/autoload.php");	//require mPDF file//

$maintn_id = $_GET['maintn_id'];
/*$sql = "SELECT sell.*, desc_sell.sell_fid, product.product_id, product.product_name, desc_sell.sell_price, 
desc_sell.sell_amount, desc_sell.sell_total, desc_sell.descsell_id, customer.cus_id, customer.cus_name, 
customer.cus_add 
FROM sell 
INNER JOIN desc_sell ON sell.sell_id = desc_sell.sell_fid 
INNER JOIN product ON desc_sell.product_fid = product.product_id
INNER JOIN customer ON sell.cus_fid = customer.cus_id
WHERE sell_id=:sell_id";
$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute([':sell_id' => $sell_id]);

$stmt2 = $db->prepare($sql);//prepare data after select//
$stmt2->execute([':sell_id' => $sell_id]);*/

$sql = "SELECT maintenance.*, maintenance.maintn_title, macchine_history.maintn_fid, macchine_history.mch_id, macchine_history.mch_date, macchine_history.mch_desc, macchine_history.mch_title 
FROM maintenance 
INNER JOIN macchine_history ON maintenance.maintn_id = macchine_history.maintn_fid 
WHERE maintn_id=:maintn_id 
ORDER BY maintenance.maintn_id ";
$stmt = $db->prepare($sql);//prepare data after select//
$stmt->execute([':maintn_id' => $maintn_id]);

$stmt2 = $db->prepare($sql);//prepare data after select//
$stmt2->execute([':maintn_id' => $maintn_id]);
///////////////////////////////////////////////////////////////////////////////////
	$table="";
	$table .= "

	<table align='center' style='width:100%;' border='1'>
	      <thead 'border:0' >
	        <tr style='background:grey;' >
	          <th style='width: 5%'>ลำดับ</th>
	          <th style='width: 50%'>รายการซ่อม</th>
	          <th style='width: 20%'>วัที่ซ่อม</th>
	          <th style='width: 25%'>ชื่อผู้ซ่อม</th>
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
	$mpdf->WriteHTML('<p style="border:1" width="30%">&nbsp;<b>โรงงานผลิตเซรามิค บ.เซรามิค จำกัด</b><br>&nbsp;<b>ที่อยู่:</b> 1/118 <b>ต</b>.รูสะมิแล <b>อ</b>.เมือง <b>จ</b>.ปัตตานี 94000</p>');	//write topic//
	$mpdf->WriteHTML('<h3 style="text-align: center">ประวัติการซ่อม</h3></center>');	//write topic//

	$round = true;
	while($rows = $stmt2->fetch(PDO::FETCH_OBJ))
	{
		if ($round)
		{
			$mpdf->WriteHTML("<b>ชื่อเครื่องจักร</b> :&nbsp;&nbsp;$rows->maintn_title");
			$round = false;
		}
		else
            {
            	$mpdf->WriteHTML("");
            }
	}

	$mpdf->WriteHTML("<hr>"); //write horizonetal line//
	$mpdf->WriteHTML($table);//write table head// by variable//
	$mpdf->shrink_tables_to_fit = 1;	//Set to fit paper//

	$num_row= 0; //New variable use count row//
	$total =0;     //รวมยอดทั้งหมด
	while($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		$num_row++;   //row +1;
		/*  $sumeachTotal= $row->sell_total;
          $total = $sumeachTotal + $total;*/
								//loop table row//
	    $mpdf->WriteHTML("<table border='0' width='100%' font='16px' style='font-size: 14pt;'>");
		$mpdf->WriteHTML("<tr style='border:1'>
							<td style='width: 6%'>$num_row</td>
							<td style='width: 50%'>$row->mch_desc</td>
		    				<td style='width: 20%'>$row->mch_date</td>
		    				<td style='width: 25%'>$row->mch_title</td>
		    			</tr>");
		$mpdf->WriteHTML("</table>");
	}
	//END loop table//
	$mpdf->WriteHTML("<hr>");
	$mpdf->WriteHTML('จำนวนรายการ : </b>'.$num_row .'&nbsp;รายการ<br>');
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
        <td width="33%" style="text-align: right;">ใบแจ้งหนี้ลูกค้า</td>
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
<?
include_once('./_common.php');
include_once("Classes/PHPExcel.php");

set_time_limit(0);
//header("Content-type:application/vnd.ms-excel; charset=utf-8");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
header("Content-Disposition:attachment; filename=".iconv('utf-8','euc-kr',"랭킹스타_쿠폰_목록(".date('Ymd').").xlsx")."");
header("Pragma:public");

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

$defaultBorder = array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb'=>'000000'));
$headBorder = array('borders' => array('bottom' => $defaultBorder, 'left'   => $defaultBorder, 'top'    => $defaultBorder, 'right'  => $defaultBorder));
foreach(range('A','I') as $i => $cell){ $sheet->getStyle($cell.'1')->applyFromArray( $headBorder ); }
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->duplicateStyleArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'F3F3F3'))),	'A1:I1');
$sheet->duplicateStyleArray(array('font' => array('bold' => true, 'size' => 9), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER)), 'A1:I1');
$sheet->setTitle("Pico U");
$sheet->setSelectedCellByColumnAndRow(0, 1);
$sheet->getColumnDimension('A')->setWidth(10);
$sheet->getColumnDimension('B')->setWidth(10);
$sheet->getColumnDimension('C')->setWidth(10);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(50);
$sheet->getColumnDimension('F')->setWidth(50);
$sheet->getColumnDimension('G')->setWidth(60);
$sheet->getColumnDimension('H')->setWidth(20);
$sheet->getColumnDimension('I')->setWidth(20);
$sheet->getColumnDimension('J')->setWidth(15);
$sheet->getRowDimension(1)->setRowHeight(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '번 호');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '사 은 품');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '고 객 명');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '연 락 처');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '우 편 번 호');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '도 로 명 주 소');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '지 번 주 소');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '배 송 요 청 사 항');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '등 록 일');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '상 태');

$objPHPExcel->createSheet(); 
$objPHPExcel->setActiveSheetIndex(1);
$sheet = $objPHPExcel->getActiveSheet();

$defaultBorder = array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb'=>'000000'));
$headBorder = array('borders' => array('bottom' => $defaultBorder, 'left'   => $defaultBorder, 'top'    => $defaultBorder, 'right'  => $defaultBorder));
foreach(range('A','I') as $i => $cell){ $sheet->getStyle($cell.'1')->applyFromArray( $headBorder ); }
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->duplicateStyleArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'F3F3F3'))),	'A1:I1');
$sheet->duplicateStyleArray(array('font' => array('bold' => true, 'size' => 9), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER)), 'A1:I1');
$sheet->setTitle("기어 VR");
$sheet->setSelectedCellByColumnAndRow(0, 1);
$sheet->getColumnDimension('A')->setWidth(10);
$sheet->getColumnDimension('B')->setWidth(10);
$sheet->getColumnDimension('C')->setWidth(10);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(50);
$sheet->getColumnDimension('F')->setWidth(50);
$sheet->getColumnDimension('G')->setWidth(60);
$sheet->getColumnDimension('H')->setWidth(20);
$sheet->getColumnDimension('I')->setWidth(20);
$sheet->getRowDimension(1)->setRowHeight(15);

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', '번 호');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', '사 은 품');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', '고 객 명');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', '연 락 처');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1', '우 편 번 호');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1', '도 로 명 주 소');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', '지 번 주 소');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', '배 송 요 청 사 항');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I1', '등 록 일');

//$deliveryinfo = $_GET['deliveryinfo'];

$pQuery="select cp_number from g5_shop_cp";
$pResult=sql_query($db,$pQuery);
$pRows=mysqli_num_rows($pResult);
$pTotal=$pRows;

$curNumber=$pTotal;

$pField='cp_number';
$pQuery="select $pField from g5_shop_cp";
$pResult=sql_query($db,$pQuery);

$i=1;
while($pRow=sql_fetch_array($pResult)){
	  $i++;
	  $number=$pRow['cp_number']; // 증가번호

	  if(decrypt($tel1)&&decrypt($tel2)&&decrypt($tel3)){ $t1= decrypt($tel1).'-'.decrypt($tel2).'-'.decrypt($tel3); }

	  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $curNumber);

	  $curNumber--;
}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
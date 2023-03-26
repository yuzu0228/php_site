<?php
// ライブラリ読込
require 'vendor/autoload.php';
require_once "excelexport/ExportExcelFile.php";

session_start();
session_regenerate_id(true);
if(isset($_SESSION['ecode'])==false) {
    print '<a href="logout.php">ログイン画面へ</a>';
    exit();
}

if(isset($_POST["excelexport"]) && isset($_POST["exportkind"])) 
{
   //出力ファイルに応じて渡す変数を定義
   switch ($_POST["exportkind"])
   {
      case 'syukinbo':
         $arg = [$_SESSION['ecode'], $_POST["yyyymm"]];
   }

   $excel = new ExportExcelFile();
   $filename = $excel->ExportFile($_POST["exportkind"], $arg);

   $filenameNopath = substr($filename, strpos($filename, '_') + 2, strlen($filename) - (strpos($filename, '_')));

   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;');
   header("Content-Disposition: attachment; filename=" . $filenameNopath);
   header('Cache-Control: max-age=0');


   $inputFileType = PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
   $reader = PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
   //バッファのゴミ削除
   ob_end_clean();
   $spreadsheet = $reader->load($filename);

   $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
   $writer->save('php://output');
   exit;
}
?>
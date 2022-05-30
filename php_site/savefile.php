<?php
// ライブラリ読込
require 'vendor/autoload.php';

require_once "excelexport/ExportExcelFile.php";

 //download.phpで「ダウンロード」ボタンが押されているかどうかをチェックします。
 if(isset($_POST["excelexport"])) 
 {
    $excel = new ExportExcelFile();
    $filename = $excel->ExportFile();

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
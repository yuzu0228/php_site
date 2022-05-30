<?php

// ライブラリ読込
require 'vendor/autoload.php';

// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

class ExportExcelFile {

    public function ExportFile() 
    {
        // Spreadsheetオブジェクト生成
        $objSpreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        // シート設定
        $objSheet = $objSpreadsheet->getActiveSheet();
        
        // タイトル
        $objSheet->setCellValue('A1', 'Excel出力テスト');
        
        // セルの結合
        $objSheet->mergeCells('A1:C1');
        
        $objSheet->setCellValue('A2', 'No');
        $objSheet->setCellValue('A3', '1');
        $objSheet->setCellValue('A4', '2');
        $objSheet->setCellValue('A5', '3');
        
        
        $objSheet->setCellValue('B2', '名称');
        $objSheet->setCellValue('B3', 'テスト1');
        $objSheet->setCellValue('B4', 'テスト2');
        $objSheet->setCellValue('B5', 'テスト3');
        
        // 書式「数字」を指定
        $objSheet->setCellValue('C2', '金額');
        $objSheet->setCellValueExplicit('C3', '10000', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $objSheet->setCellValueExplicit('C4', '20000', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $objSheet->setCellValueExplicit('C5', '30000', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        
        // ヘッダ部:太線
        $objSheet->getStyle('A2:C2')->getBorders()->getAllBorders()->setBorderStyle('thick');
        // データ部:細線
        $objSheet->getStyle('A3:C5')->getBorders()->getAllBorders()->setBorderStyle('thin');
        
        // XLSX形式オブジェクト生成
        $objWriter = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($objSpreadsheet);

        $date = date('Y-m-d H:i:s');
        $date = str_replace(' ', '', str_replace(':', '', str_replace('-', '', $date)));
        $filename = '.\\export\\syukkinbo_\\test' . $date . '.xlsx';

        // Excelファイルの出力
        $objWriter->save($filename);
        
        return $filename;
    }
}
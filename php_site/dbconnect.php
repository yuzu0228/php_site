<?php

function ConnectDB(){
    $xml = 'xml\info.xml';
    $xmlData = simplexml_load_file($xml);

    foreach ($xmlData->database as $data) {
        $servername = $data->servername;
        $dbname = $data->dbname;
        $uid = $data->loginid;
        $pwd = $data->pw;
    }

    try{
        $dsn = 'sqlsrv:server=' . $servername . ';database=' . $dbname;
        global $db;
        $db = new PDO($dsn, $uid, $pwd);

        return $db;
        
        } catch (PDOexception $e) {
            echo '接続エラー' . $e->getMassage();
        }
}
?>
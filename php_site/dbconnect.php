<?php
class DBConnect {

    private static $db = null;

    function ConnectDB(){

        if (!is_null(self::$db)) {
			return self::$db;
		}

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
            
            self::$db = new PDO($dsn, $uid, $pwd);
    
            return self::$db;
            
            } catch (PDOexception $e) {
                echo '接続エラー' . $e->getMassage();
            }
    }
}


?>
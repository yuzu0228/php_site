<?php
try{
    $dsn = 'sqlsrv:server=LAPTOP-EFK0JSGP\SQLEXPRESS;database=DB_1';
    $uid = 'yuzu';
    $pwd = '15230228yuzu';
    $db = new PDO($dsn, $uid, $pwd);
    } catch (PDOexception $e) {
        echo '接続エラー' . $e->getMassage();
    }
?>
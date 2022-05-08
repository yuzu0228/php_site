<?php
require_once "dbconnect.php";
class CreateSQL{
    public function Read($arg, $no) {
        $dbc = new DBConnect();
        $db = $dbc->ConnectDB();

        switch ($no) {
            case '1': //ログイン検証
                $sql = 'SELECT COUNT(ECODE) FROM EMPLOYEE WHERE ECODE=? AND PW =?';

            case '2': //ログインユーザー名取得
                $sql = 'SELECT ECODE, ENAME FROM EMPLOYEE WHERE ECODE =?';

            default;
        }

        try {
            $select = $db -> prepare($sql);
            $select -> execute($arg);
            $ret = $select -> fetch();
        } 
        catch (PDOexception $e)
        {
            $ret = ['error', $e->getMessage()];
            return $ret;
        }

        return $ret;
    }

    public function InsertLog ($arg) {
        $dbc = new DBConnect();
        $db = $dbc->ConnectDB();

        $sql = 'INSERT INTO [LOG] VALUES (?, ?, dbo.GetDate_l19(), ?)';

        try {
            $insert = $db -> prepare($sql);
            $insert -> execute($arg);
            $ret = $insert -> fetch();
        } 
        catch (PDOexception $e)
        {
            $ret = ['error', $e->getMessage()];
            return $ret;
        }
    }
}
?>
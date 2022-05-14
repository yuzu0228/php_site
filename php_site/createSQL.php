<?php
require_once "dbconnect.php";
class CreateSQL{
    public function Read($arg, $no) {
        $dbc = new DBConnect();
        $db = $dbc->ConnectDB();

        switch ($no) {
            case '1': //ログイン検証
                $sql = 'SELECT COUNT(ECODE) FROM EMPLOYEE WHERE ECODE= ? AND PW = ?';
                break;

            case '2': //ログインユーザー名取得
                $sql = 'SELECT ECODE, ENAME FROM EMPLOYEE WHERE ECODE = ?';
                break;

            case '3': //当月の出勤簿取得
                $sql = "SELECT * FROM WORKRECORD WHERE ECODE = ? AND substring(DATE, 1, 6) = replace(?, '-', '')";
                break;

            case '4': //当日の出勤時間を取得
                $sql = "SELECT * FROM WORKRECORD WHERE ECODE = ? AND DATE = replace(iif(len('" . $arg[1] . "')= 9, stuff('" . $arg[1] . "', 9, 0, '0'), ?), '-', '')";
                break;
        }

        try {
            $select = $db -> prepare($sql);
            $select -> execute($arg);
            $ret = $select -> fetchAll();
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
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
                $sql = "SELECT * FROM WORKRECORD JOIN EMPLOYEE ON (WORKRECORD.ECODE = EMPLOYEE.ECODE) WHERE WORKRECORD.ECODE = ? AND substring(WORKRECORD.DATE, 1, 6) = replace(?, '-', '')";
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

    public function Update ($arg, $no, $kind) {
        $dbc = new DBConnect();
        $db = $dbc->ConnectDB();

        switch ($no) {
            case '1':
                $sql = "UPDATE WORKRECORD SET STIME = ?, FTIME = ?, WORKFLG = '1' WHERE ECODE = ? AND DATE = replace(iif(len('" . $arg[3] . "')= 9, stuff('" . $arg[3] . "', 9, 0, '0'), ?), '-', '')";
                break;
            case '2':
                break;
        }

        try {
            if ($kind == "Query") {
                $insert = $db -> prepare($sql);
                $insert -> execute($arg);
                $ret = $insert -> fetch();
            } elseif($kind == "SP") {
                $insert = $db -> prepare('{ call dbo.NewRecord_WORKRECORD_SP(?, ?) }');
                $insert->bindParam(1, $arg[0], PDO::PARAM_STR);
                $insert->bindParam(2, $arg[1], PDO::PARAM_STR);
                $insert -> execute();
                $ret = $insert -> fetch();
            }

        } 
        catch (PDOexception $e)
        {
            $ret = ['error', $e->getMessage()];
            return $ret;
        }
    }
}
?>
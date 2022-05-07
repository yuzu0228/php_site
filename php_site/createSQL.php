<?php
class CreateSQL{
    public function Read($arg, $no, $db) {
        switch ($no) {
            case '1':
                $sql = 'SELECT COUNT(ECODE) FROM EMPLOYEE WHERE ECODE=? AND PW =?';

            default;
        }

        try {
            $select = $db -> prepare($sql);
            $select -> execute($arg);
            $ret = $select -> fetch();
        } 
        catch (PDOexception $e)
        {

        }



        return $ret;
    }

    public function InsertLog ($arg, $db) {
        $sql = 'INSERT INTO [LOG] VALUES ()';
    }
}
?>
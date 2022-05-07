<?php
require('dbconnect.php');
 $code = $_POST['ecode'];
 $pw = $_POST['pw'];

 $sql = $db -> prepare('SELECT COUNT(ECODE) FROM EMPLOYEE WHERE ECODE=? AND PW =?');
 $sql -> execute([$code, $pw]);
 $ret = $sql -> fetch();
 if ($ret[0] == "0"){
    $test_alert = "<script type='text/javascript'>alert('ログインに失敗しました。');</script>";
    echo $test_alert;
 }
 else {
    echo "ログイン成功";
 }
 $db = null
?>
<?php
require_once "createSQL.php";
session_start();
session_regenerate_id(true);
if(isset($_SESSION['ecode'])==false) {
    print '<a href="logout.php">ログイン画面へ</a>';
    exit();
}

$createSQL = new CreateSQL;
$arg = [$_SESSION['ecode']];
$ret = $createSQL->read($arg, '2');
if ($ret[0] == "error") {
    echo $ret[1];
}

require('header.php');
?>

<body>
<div class="container border">
    <div class="">
        <p class="">メインメニュー</p>
        <pp class="ecode"><?php echo $ret[0]['ECODE'].':'.$ret[0]['ENAME']?></p>
    </div>
    <div class="d-flex justify-content-center align-items-center " style="height:300px;">
        <a href="calendar.php" class="btn btn-primary" style="margin:10px;">カレンダーテスト</a><br>
        <a href="logout.php"  class="btn btn-primary" style="margin:10px;">ログアウト</a>
    </div>
</div>
</body>
</html>
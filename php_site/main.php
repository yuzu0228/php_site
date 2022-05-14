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
<p>メインメニュー</p>
<div class="container">
<div class="border d-flex " style="height:300px;">
<div class="position-absolute.top-0.end-0">
<p><?php echo $ret[0]['ECODE'].':'.$ret[0]['ENAME']?></p>
</div>
</div>
</div>
<a href="calendar.php">カレンダーテスト</a>
<a href="logout.php">ログアウト</a>
</body>
</html>
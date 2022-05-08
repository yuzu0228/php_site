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
<p>main</p>
<?php 
echo '<p>'.$ret['ECODE'].':'.$ret['ENAME'].'</p>';
?>
<a href="logout.php">ログアウト</a>
</body>
</html>
<?php
require_once "createSQL.php";
session_start();
//session_regenerate_id(true);
if(isset($_SESSION['ecode'])==false) {
    print '<a href="logout.php">ログイン画面へ</a>';
    exit();
}
require('header.php');

$createSQL = new CreateSQL;

if (isset($_POST['stime'])) {
  echo $_POST['stime'] . $_POST['ftime'];
  $arg = [$_POST['stime'], $_POST['ftime'], $_SESSION['ecode'], $_GET['date']];
  $ret = $createSQL->Update($arg, '1');

  $alert = "<script type='text/javascript'>alert('更新しました。');</script>";
  echo $alert;
}

if (isset($_GET['date'])) { $date = $_GET['date']; }
echo $date;

//当月の出勤簿データを取得
$arg = [$_SESSION['ecode'], $_GET['date']];
$ret = $createSQL->read($arg, '4');
?>

<body>
<a href="logout.php">ログアウト</a>
<div class="container">
  <div class="border d-flex align-items-center justify-content-center" style="height:300px;">
    <form action="" method="post">
        <label for="time">稼働時間:</label>
        <?php
        if (count($ret) == 0) {
            echo '<p><input type="time" name="stime" min="00:00" max="23:59" value="09:00"></p>';
            echo '<p><input type="time" name="ftime" min="00:00" max="23:59" value="00:00"></p>';
        } else {
            echo '<p><input type="time" name="stime" min="00:00" max="23:59" value="' . $ret[0]['STIME'] .'"></p>';
            echo '<p><input type="time" name="ftime" min="00:00" max="23:59" value="' . $ret[0]['FTIME'] .'"></p>';
        }
        ?>
        <br><br>
        <input type="submit" name="send" value="更新">
    </form>
  </div>
  <a href="../calendar.php">カレンダーに戻る</a>
</div>
</body>
</html>
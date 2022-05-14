<?php
require_once "createSQL.php";
require('header.php');

if(isset($_GET['date'])) { $date = $_GET['date']; }
echo $date;

//当月の出勤簿データを取得
$createSQL = new CreateSQL;
$arg = ['0000000001', $_GET['date']];
$ret = $createSQL->read($arg, '4');
?>

<body>
<div class="container">
  <div class="border d-flex align-items-center justify-content-center" style="height:300px;">
    <form action="" method="post">
        <label for="code">稼働時間:</label>
        <?php
        if (count($ret) == 0) {
            echo '<p><input type="time" name="example" min="08:00" max="08:59" value="09:00"></p>';
            echo '<p><input type="time" name="example" min="08:00" max="08:59" value="00:00"></p>';
        } else {
            echo '<p><input type="time" name="example" min="08:00" max="08:59" value="' . $ret[0]['STIME'] .'"></p>';
            echo '<p><input type="time" name="example" min="08:00" max="08:59" value="' . $ret[0]['FTIME'] .'"></p>';
        }
        ?>
        <br><br>
        <input type="submit" name="send" value="更新">
    </form>
  </div>
  <a href="javascript:history.back()">戻る</a>
</div>
</body>
</html>
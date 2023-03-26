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

if (isset($_POST['TimeUpdate'])) {

//出勤簿の存在チェック
  $arg = [$_SESSION['ecode'], $_GET['date']];
  $ret = $createSQL->read($arg, '4');
  if (!isset($ret[0])) {
    $ret = $createSQL->Update($arg, '2', 'SP');
  }

  echo $_POST['stime'] . $_POST['ftime'];
  $arg = [$_POST['stime'], $_POST['ftime'], $_SESSION['ecode'], $_GET['date']];
  $ret = $createSQL->Update($arg, '1', 'Query');

  $alert = "<script type='text/javascript'>alert('更新しました。');</script>";
  echo $alert;
}

if (isset($_POST['DetailUpdate'])) {

}

if (isset($_GET['date'])) { $date = $_GET['date']; }
echo $date;

//当日の出勤簿データを取得
$arg = [$_SESSION['ecode'], $_GET['date']];
$ret = $createSQL->read($arg, '4');
?>

<script type="text/javascript">
/*
 * appendRow: テーブルに行を追加
 */
function appendRow()
{
    var objTBL = document.getElementById("tbl");
    if (!objTBL)
        return;
    
    var count = objTBL.rows.length;
    
    // 最終行に新しい行を追加
    var row = objTBL.insertRow(count);

    // 列の追加
    var c1 = row.insertCell(0);
    var c2 = row.insertCell(1);
    var c3 = row.insertCell(2);
    var c4 = row.insertCell(3);
    var c5 = row.insertCell(4);
    var c6 = row.insertCell(5);

    // 各列にスタイルを設定
    c1.style.cssText = "text-align:right; width:40px;";
    c2.style.cssText = "";
    c3.style.cssText = "width:40px;";
    c4.style.cssText = "width:40px;";
    c5.style.cssText = "width:40px;";
    c6.style.cssText = "width:40px;";
    
    // 各列に表示内容を設定
    c1.innerHTML = '<span class="seqno">' + count + '</span>';
    c2.innerHTML = '<input class="inpval" type="text"   id="ankno' + count + '" name="ankno' + count + '" value="" size="30" style="border:1px solid #888;">';
    c3.innerHTML = '<input class="inpval" type="text"   id="ankname' + count + '" name="ankname' + count + '" value="" size="30" style="border:1px solid #888;">';
    c4.innerHTML = '<input class="inpval" type="text"   id="time' + count + '" name="time' + count + '" value="" size="30" style="border:1px solid #888;">';
    c5.innerHTML = '<input class="inpval" type="text"   id="detail' + count + '" name="detail' + count + '" value="" size="30" style="border:1px solid #888;">';
    c6.innerHTML = '<input class="delbtn" type="button" id="delBtn' + count + '" value="削除" onclick="deleteRow(this)">';
    
    // 追加した行の入力フィールドへフォーカスを設定
    var objInp = document.getElementById("ankno" + count);
    if (objInp)
        objInp.focus();
}


</script>
<script type="text/javascript">
function DetailUpdate() {
  var objTBL = document.getElementById("tbl");
    if (!objTBL)
        return;

  var tbl[,];

  for (var i=0; i < mytable.rows.length; i++) {
    for(var j=0; j < mytable.rows[i].cells.length; j++){
       tbl[i.length, j] = mytable.rows[i].cells[j].innerHTML;
       console.log(  "(" + i + "," + j + ") : " + mytable.rows[i].cells[j].innerHTML);
    }
  }
}
</script> 

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
        <br>
        <input type="submit" name="TimeUpdate" value="更新">

        <form id="frm" name="frm" method="GET" action="">
        <div>新しい行を追加：<input type="button" id="add" name="add" value="追加" onclick="appendRow()"></div>
        <table border="1" id="tbl">
        <tr>
            <th style="text-align:right; width:40px;">No</th>
            <th style="">案件番号</th>
            <th style="width:40px;">案件名</th>
            <th style="width:40px;">作業時間</th>
            <th style="width:40px;">作業内容</th>
            <th style="width:40px;"> </th>
        </tr>
        <tr>
            <td style="text-align:right; width:40px;"><span class="seqno">1</span></td>
            <td style=""><input class="inpval" type="text" id="ankno" name="ankno" value="" size="30" style="border:none"></td>
            <td style=""><input class="inpval" type="text" id="ankname" name="ankname" value="" size="30" style="border:none"></td>
            <td style=""><input class="inpval" type="text" id="time" name="time" value="" size="30" style="border:none"></td>
            <td style=""><input class="inpval" type="text" id="detail" name="detail" value="" size="30" style="border:none"></td>
            <td style="width:40px;"><input class="delbtn" type="button" id="delBtn1" value="削除" onclick="deleteRow(this)"></td>
        </tr>
        </table>

        <input type="button" name="DetailUpdate" value="更新" onclick="DetailUpdate()">

        <br>
    </form>
  </div>
  <a href="../calendar.php?ym=<?php echo substr($date, 0, 7); ?>">カレンダーに戻る</a>
</div>
</body>
</html>
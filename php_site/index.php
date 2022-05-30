<?php
//require_once "dbconnect.php";
require_once "createSQL.php";
require_once "excelexport/ExportExcelFile.php";
ini_set('display_errors', 1);

session_start();
session_regenerate_id(true);

//test
if(isset($_POST['excelexport'])){
  $excel = new ExportExcelFile();
  $excel->ExportFile("./exceltemplate/出勤簿.xlsx");
  
}

if(empty($_POST)) {
  
  if(isset($_SESSION['ecode']) && $_SESSION['time'] + 3600 > time()) {
    //ログインしている
    $_SESSION['time'] = time();

    header('Location: main.php');
    exit();
  }
}


if(!empty($_POST)) {
  if($_POST['ecode'] != '' && $_POST['pw'] != '') {
    $arg = [$_POST['ecode'], $_POST['pw']];
    $createSQL = new CreateSQL;
    $ret = $createSQL->read($arg, '1');
 
    if ($ret[0][0] == "0"){
      //ログイン失敗
      $alert = "<script type='text/javascript'>alert('ログインに失敗しました。');</script>";
      echo $alert;
    }
    else if ($ret[0] == "error"){
      echo $ret[1];
    }
    else {
      //ログイン成功
      $_SESSION['ecode'] = $_POST['ecode'];
      $_SESSION['time'] = time();

      $arg = ['1','ログイン成功',$_POST['ecode']];
      $createSQL->InsertLog($arg);

      header('Location: main.php');
      exit();
    }
  }
}

require('header.php');
?>

<body>
<div class="container">
  <div class="border d-flex align-items-center justify-content-center" style="height:300px;">
    <form action="" method="post">
        <label for="code">従業員番号:</label>
        <input type="text" id="ecode" name="ecode" required maxlength="10" size="10">
        <br><br>
        <label for="pw">パスワード:</label>
        <input type="password" id="pw" name="pw" required maxlength="100" size="10">
        <br><br>
        <input type="submit" name="send" value="ログイン">
    </form>
  </div>
  <a href="calendar.php">カレンダーテスト</a>

    <form action="savefile.php" method="post">
      <input type="submit" name="excelexport" value="Excel出力"/>

    </form>
</div>
</body>
</html>
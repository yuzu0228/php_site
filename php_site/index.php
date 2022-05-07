<?php
require_once "dbconnect.php";
require_once "createSQL.php";
ini_set('display_errors', 1);

session_start();
session_regenerate_id(true);

$db = ConnectDB();

if(empty($_POST)) {
  
  /*
  if($_COOKIE['ecode'] != '') {
    //クッキーによる自動ログイン処理
    $_POST['ecode'] = $_COOKIE['ecode'];
    $_POST['pw'] = $_COOKIE['pw'];
    $_POST['save'] = 'on';
  }*/
  
  
  if(isset($_SESSION['ecode']) && $_SESSION['time'] + 3600 > time()) {
    //ログインしている
    $_SESSION['time'] = time();

    header('Location: main.php');
    exit();
    //$members = $db -> prepare('SELECT * FROM members WHERE id=?');
    //$members -> execute([$_SESSION['id']]);
    //$member = $members -> fetch();
  }
}


if(!empty($_POST)) {
  if($_POST['ecode'] != '' && $_POST['pw'] != '') {
    $arg = [$_POST['ecode'], $_POST['pw']];
    $createSQL = new CreateSQL;
    $ret = $createSQL->read($arg, '1', $db);
 
    if ($ret[0] == "0"){
      //ログイン失敗
      $alert = "<script type='text/javascript'>alert('ログインに失敗しました。');</script>";
      echo $alert;
    }
    else {
      //ログイン成功
      $_SESSION['ecode'] = $_POST['ecode'];
      $_SESSION['time'] = time();

      //ログイン情報を記録
      setcookie('ecode', $_POST['ecode'], time()+60*60*24*14);
      setcookie('pw', $_POST['pw'], time()+60*60*24*14);


      header('Location: main.php');
      exit();
    }
  }
  
}
?>

<head>
<title>test</title>
</head>
<style type="text/css"></style>
<body>
<!--
<table>
<?php
$sqlt = "SELECT * FROM EMPLOYEE";

foreach ($db->query($sqlt) as $row) {
print("<tr><td>".$row['ECODE']."</td>");
print("<td>".$row["ENAME"]."</td></tr>");
}
$db = null;
?>
</table>
-->

<form action="" method="post">
    <label for="code">従業員番号:</label>
    <input type="text" id="ecode" name="ecode" required minlength="4" maxlength="10" size="10">
    <label for="pw">パスワード:</label>
    <input type="text" id="pw" name="pw" required minlength="4" maxlength="100" size="10">
    <!--<input type="button" value="ボタン" onclick="clickBtn1()" />-->

    <input type="submit" name="send" value="ログイン">
</form>

<script>
  function clickBtn1() {
    var $ecode = document.getElementById("ecode").value;
    var $pw = document.getElementById("pw").value;
    //document.getElementById("span1").textContent = t1;
  }
</script>

</body>
</html>
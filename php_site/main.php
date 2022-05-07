<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['ecode'])==false) {
    print '<a href="logout.php">ログイン画面へ</a>';
    exit();
}
?>
<head>
<title>test</title>
</head>
<style type="text/css"></style>
<body>
<p>main</p>
<a href="logout.php">ログアウト</a>
</body>
</html>
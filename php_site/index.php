<?php
require('dbconnect.php');
?>

<head>
<title>PHPてすとだよ</title>
</head>
<style type="text/css">

table,td,th{
border-collapse: collapse;
border:1px solid #333;
}
</style>
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

<form action="login.php" method="post">
    <label for="code">従業員番号:</label>
    <input type="text" id="code" name="code" required minlength="4" maxlength="10" size="10">
    <label for="name">パスワード:</label>
    <input type="text" id="pw" name="pw" required minlength="4" maxlength="100" size="10">

    <input type="submit" name="send" value="ログイン">
</form>



</body>
</html>
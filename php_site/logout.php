<?php
// セッションの初期化
session_start();

require_once "createSQL.php";
$createSQL = new CreateSQL;
$arg = ['1', 'ログアウト', $_SESSION['ecode']];
$createSQL->InsertLog($arg);

// セッション変数を全て解除する
$_SESSION = array();

// セッションを切断するにはセッションクッキーも削除する。
// Note: セッション情報だけでなくセッションを破壊する。
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 最終的に、セッションを破壊する
session_destroy();

//cookieも破棄
setcookie('ecode', '', time() - 3600);
setcookie('pw', '', time() - 3600);

header('Location: index.php');
exit();
?>
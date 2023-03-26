<?php

// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');
require_once "createSQL.php";
session_start();
//session_regenerate_id(true);
if(isset($_SESSION['ecode'])==false) {
    print '<a href="logout.php">ログイン画面へ</a>';
    exit();
}

// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
if (!empty($_POST['yyyymm'])) {
    $ym = $_POST['yyyymm'];
} elseif (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // 今月の年月を表示
    $ym = date('Y-m');
}

//当月
$timestamp_now =strtotime(date('Y-m'), '-01');

//当月の出勤簿データを取得
$createSQL = new CreateSQL;
$arg = [$_SESSION['ecode'], $ym];
$ret = $createSQL->read($arg, '3');

// タイムスタンプを作成し、フォーマットをチェックする
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// 今日の日付 フォーマット　例）2021-06-3
$today = date('Y-m-j');

// カレンダーのタイトルを作成　例）2021年6月
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
// 方法１：mktimeを使う mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// 方法２：strtotimeを使う
// $prev = date('Y-m', strtotime('-1 month', $timestamp));
// $next = date('Y-m', strtotime('+1 month', $timestamp));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か　0:日 1:月 2:火 ... 6:土
// 方法１：mktimeを使う
$youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
// 方法２
// $youbi = date('w', $timestamp);


// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
// 例）１日が火曜日だった場合、日・月曜日の２つ分の空セルを追加する
$week .= str_repeat('<td></td>', $youbi);

for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

    // 2021-06-3
    $date = $ym . '-' . $day;

    //未来の月はリンク付けない
    if ($timestamp > $timestamp_now) {
        if ($today == $date) {
            $week .= '<td class="today">' . $day . '</td>';
        } else {
            $week .= '<td>' . $day . '</td>';
        }
    } else {
        if ($today == $date) {
            // 今日の日付の場合は、class="today"をつける
            $week .= '<td class="today"><a href="input.php/?date=' . $day . '">' . $day;
        } else {
            $week .= '<td><a href="input.php/?date=' . $date . '">' . $day;
        }

        if (count($ret) == 0) {
            $week .= '</a></td>';
        } else {
            if ($ret[$day - 1]['WORKFLG'] == "0") {
                $week .= '</a></td>';
            } else {
                $week .= '<br>'. $ret[$day - 1]['STIME'] . ' ～ ' . $ret[$day - 1]['FTIME'] . '</a></td>';
            }
        }
    }

    // 週終わり、または、月終わりの場合
    if ($youbi % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // 月の最終日の場合、空セルを追加
            // 例）最終日が水曜日の場合、木・金・土曜日の空セルを追加
            $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }

        // weeks配列にtrと$weekを追加する
        $weeks[] = '<tr>' . $week . '</tr>';

        // weekをリセット
        $week = '';
    }
}


require('header.php');
?>
<body>
<a href="logout.php">ログアウト</a>
<a href="main.php">メインメニュー</a>
<form action="savefile.php" method="post">
    <input type="hidden" name="exportkind" value="syukinbo" >
    <input type="hidden" name="yyyymm" value=<?php echo $ym; ?> >
    <input type="submit" name="excelexport" value="Excel出力"/>
</form>
    <div class="container">
    <h3 class="mb-5"><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
    <form action="" method="post">
        <label for="code">年月指定</label>
        <input type="text" id="yyyymm" name="yyyymm" required maxlength="10" size="10">
        <input type="submit" name="send" value="検索">
    </form>
        <table class="table table-bordered" width = "200">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>

</body>
</html>

<?php
    date_default_timezone_set('Asia/Tokyo');
    
    /*
    $year:西暦
    $month:月
    $year年$month月のカレンダーを生成する
    */
    function calendar($year,$month){
        $weekName = array("日","月","火","水","木","金","土");

        echo '<table>';
        echo '<tr>';
        //曜日を表示
        foreach( $weekName as $name ){
            echo '<th>' . $name . '</th>';
        }
        echo '</tr>';

        
        //カレンダーを6週間分出力
        
        $lastMonth = $month - 1;    //先月
        if($lastMonth === 0)$lastmonth = 12;
        $yearMonth = "$year-$month";    //今年と今月
        $yearLastMonth = "$year-$lastMonth";    //今年と先月
        $firstDate = date('Y-m-d', strtotime('first day of ' . $yearMonth));//今月の月初
        $lastDate = date('j', strtotime('last day of' . $yearMonth));//今月末
        $lastMonthLastDay = date('j', strtotime('last day of' . $yearLastMonth));//先月末の日にち
        $firstDayOfWeek = date('w', strtotime("$year-$month-01"));   //月初の曜日0(日)～6(土)

        echo '<p class="now-calendar">' . $yearMonth . 'のカレンダーを表示中です。</p>';
        echo '<p>西暦(1970～2050)と月(1～12)はそれぞれ指定することができます。</p>';
        echo '<br>';
        

        $lastDay = $lastMonthLastDay;
        $isThisMonth = FALSE;   //今月の日付ならTRUE、今月ではない日付ならFALSE
        $today = $lastMonthLastDay - $firstDayOfWeek + 1;    //月初の日にち
        for($week = 0; $week < 6;$week++){
            echo '<tr>';
            for($day = 0;$day <= 6;$day++){
                if( $today > $lastDay ){
                    if(!$isThisMonth){
                        $isThisMonth = TRUE;
                    }else {
                        $isThisMonth = FALSE;
                    }
                    $today = 1;
                    $lastDay = $lastDate;
                }
                if( $isThisMonth ){
                    if( $day == 6 ){//土曜日の時
                        echo '<td class="this-month saturday">' . $today . '</td>';
                    }elseif( $day == 0 ){//日曜日の時
                        echo '<td class="this-month sunday">' . $today . '</td>';
                    }else {//平日の時
                        echo '<td class="this-month">' . $today . '</td>';
                    }
                }else {
                    echo '<td class="not-this-month">' . $today . '</td>';
                }
                $today++;
            }
            echo '</tr>';
        }

        echo '</table>';
    }


    $thisYear = null;
    $thisMonth = null;

    if( isset($_POST["year"]) && isset($_POST["month"]) ) {
        $year = $_POST["year"];
        $month = $_POST["month"];
        calendar($year,$month); //カレンダーを生成したい年と月を指定
        $thisYear = $year;
        $thisMonth = $month;
    }else {
        calendar(date('Y'),date('n')); //デフォルトでは今年の今月のカレンダーを表示
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>カレンダー</title>
	<meta name="Author" content="yu-dotcom"/>
	<link rel="stylesheet" type="text/css" href="./css/reset.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    
<form class="form-wrapper" method="post" action="index.php">
    <p class="select-year">
        西暦：
        <select name="year">
            <?php 
                $startYear = 1970;  //カレンダー開始年
                $endYear = 2050;    //カレンダー終了年
            
                if($thisYear == null){
                    $thisYear = date('Y');  //今年が何年か取得
                }
            
                for($year = $startYear;$year <= $endYear;$year++){
                    if( $year == $thisYear ){
                        echo "<option value=\"$year\"  selected>$year</option>";
                    }else {
                        echo "<option value=\"$year\">$year</option>";
                    }
                }
            ?>
        </select>
    </p>
    <p class="select-month">
        月：
        <select name="month">
           <?php
                if( $thisMonth == null ){
                    $thisMonth = date('n');  //今月が何月か取得
                }
                for($month = 1;$month <= 12;$month++){
                    if( $month == $thisMonth ){
                        echo "<option value=\"$month\" selected>$month</option>";
                    }else {
                        echo "<option value=\"$month\">$month</option>";
                    }
                }
            ?>
        </select>
    </p>

    <p><input type="submit" name="submit" value="表示する"></p>

</form>
</body>
</html>


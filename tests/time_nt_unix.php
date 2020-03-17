<?php
namespace kasue\nt_time;

require_once __DIR__ . '/../vendor/autoload.php';

// テストコード
var_dump(
    $nt_time = 132284440148643415,  // 2020/03/12 8:46:54 +0900
    // NTエポックタイムをUNIXタイムスタンプに変換
    time_nt_unix::convert_nttime_to_unixtime($nt_time),
    // NTエポックタイムをUNIXタイムスタンプに変換し、書式付きで表示
    time_nt_unix::convert_nttime_to_datestr(($nt_time), 'Y年m月d日 H時i分s秒 タイムゾーン：T')
);

// UNIXタイムスタンプをNTエポックタイムに変換
var_dump(
    $date = time(),     // 現在日付
    date('Y-m-d H:i:s T', $date),   // 書式表示
    time_nt_unix::convert_unixtime_to_nttime($date) // NTエポックタイム
);

// 1970/01/01 00:00:00 JST → -32400
var_dump(time_nt_unix::convert_nttime_to_unixtime(116444412000000000));

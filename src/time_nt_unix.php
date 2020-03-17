<?php
// NTエポックタイム（Windows環境で内部的に利用する日時形式： 64bit） と UNIXタイムスタンプの相互変換
//  Linux 系環境で動作する前提

namespace kasue\nt_time;

class time_nt_unix
{
    // NTエポックタイムでの 1970/01/01 00:00:00 +0000
    //      32bit 向けは秒単位  = 11644473600 秒（ /10/1000/1000)
    //      64bit 向けは100ナノ秒単位：NTエポックタイム形式
    const NT_TIME_UNIX_TIME_32 = 11644473600;
    const NT_TIME_UNIX_TIME_64 = 116444736000000000;


    // NTエポックタイム を書式を適用して表示
    static function convert_nttime_to_datestr($nt_time, $time_format = 'Y-m-d H:i:s T')
    {
        // UNIXタイムスタンプに変換
        $unit_time = self::convert_nttime_to_unixtime($nt_time);

        // NTエポックタイムをUnixタイムスタンプに変換して date 関数
        return date($time_format, $unit_time);
    }

    // NTエポックタイムをUNIXタイムスタンプに変換
    static function convert_nttime_to_unixtime($nt_time)
    {
        // UNIXタイムスタンプに換算（UNIXタイムスタンプにそろえ秒単位に変換）
        $nt_time_to_unix_time = ((int) ($nt_time/10/1000/1000) - self::NT_TIME_UNIX_TIME_32) ;
        return $nt_time_to_unix_time;
    }


    // Unix タイムスタンプをNTエポックタイムに変換
    static function convert_unixtime_to_nttime($unix_time)
    {
        // 32bit の場合処理できないため、分岐
        switch(PHP_INT_SIZE)
        {
            // 32bit
            // 秒単位前提で処理し、最後に 0000000 を文字列として付与 （string として返る。数値にすると float になってしまう）
            case 4:
                $nt_time = (($unix_time + self::NT_TIME_UNIX_TIME_32) . '0000000');
                break;

                // 64bit    100ナノ秒単位で計算
            case 8:
                $nt_time = (($unix_time*1000*1000*10) + self::NT_TIME_UNIX_TIME_64 );
                break;

            default:
                $nt_time = null;
        }

        return $nt_time;
    }
}



<?php


namespace App\Helpers;


use DateTime;

class DurationHelper
{

    public static function getCreanneauBetwennTimes($time1, $time2)
    {

        $date1 = date('Y-m-d' . $time1);
        $date2 = date('Y-m-d' . $time2);
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        return date_diff($datetime1, $datetime2)->h;
    }
    public static function addCrenneau($time1,$val){
        $strs=explode(":",$time1);
        if ($strs[1]=="00"){
            return $strs[0]+$val.':'.$strs[1];
        }else{
            return date('H:i',strtotime('+'.$val.' minutes'));
        }
    }
}

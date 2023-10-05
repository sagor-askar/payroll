<?php
namespace App\Helpers;
use Carbon\Carbon;
class Helper{

    public static function getTime($userSendTime,$systemTime){
        $enter_time = Carbon::parse($userSendTime);
        $start_time = Carbon::parse($systemTime);
        $diffInMinutes = $enter_time->diffInMinutes($start_time);
        $diffInHours = $enter_time->diffInHours($start_time);
        $hours = floor($diffInMinutes / 60);
        $diffInMinutes = $diffInMinutes % 60;
        $seconds = 0;                        
        $time = sprintf('%02d:%02d:%02d', $hours, $diffInMinutes, $seconds);
        return $time;
    }

}
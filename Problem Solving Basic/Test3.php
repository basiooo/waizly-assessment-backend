<?php

function timeConversion($time){
    $conversion = date("H:i:s", strtotime($time));
    echo $conversion ."\n";
}

timeConversion("12:01:00PM"); #12:01:00
timeConversion("12:01:00AM"); #00:01:00
timeConversion("07:05:45PM"); #19:05:45

?>
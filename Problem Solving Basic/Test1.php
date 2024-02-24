<?php

function miniMaxSum($data) {
    sort($data);
    $total = array_sum($data);

    $min_sum = $total - end($data);
    $max_sum = $total - $data[0];

    echo "$min_sum $max_sum";
    

}
$arr = [1,3,5,7,9];
miniMaxSum($arr); # 16 24

echo "\n";
$arr2 = [1,2,3,4,5];
miniMaxSum($arr2); #10 14
?>
<?php

function plusMinus($data) {
    $total_data = count($data);
    $positive = $negative = $zero = 0;

    foreach ($data as $i) {
        if ($i > 0) {
            $positive++;
        } elseif ($i < 0) {
            $negative++;
        } else {
            $zero++;
        }
    }

    echo number_format($positive / $total_data, 6, '.', '') . "\n";
    echo number_format($negative / $total_data, 6, '.', '') . "\n";
    echo number_format($zero / $total_data, 6, '.', '') . "\n";
}

plusMinus([1,1,0,-1,-1]);
// 0.400000
// 0.400000
// 0.200000
echo "=============\n";
plusMinus([-4,3,-9,0,4,1]);
// 0.500000
// 0.333333
// 0.166667

?>
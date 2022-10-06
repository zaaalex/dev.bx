<?php

$a = 4;
$b = 60;

$c = test($a, $b);
echo $c;

function test($a, $b)
{
    $c = $a + $b;

    return $c;
}



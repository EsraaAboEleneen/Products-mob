<?php

function randomString($n)
{
    $characterSet = '0123456789abcdefghABCDEFGH';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characterSet) - 1);
        $str .= $characterSet[$index];
    }
    return $str;
}
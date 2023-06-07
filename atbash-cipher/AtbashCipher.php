<?php

declare(strict_types=1);

function encode(string $text): string
{
    $text = strtolower(preg_replace("/[^\w|^\d]/", "", $text));

    $outputArr = [];
    $group = [];
    foreach (str_split($text) as $i => $char) {
        is_numeric($char) ?
            $group[] = $char :
            $group[] = chr(219 - ord($char));

        if (($i + 1) % 5 === 0 || $i + 1 === strlen($text)) {
            $outputArr[] = join($group);
            $group = [];
        }
    }

    return implode(" ", $outputArr);
}

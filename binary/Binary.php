<?php

declare(strict_types=1);

function parse_binary(string $binary): int
{
    $maxPower = strlen($binary) - 1;
    $output = 0;

    foreach (str_split($binary) as $i => $coefficient) {
        if (!is_numeric($coefficient) || (int) $coefficient >= 2) throw new InvalidArgumentException();

        $output += (int) $coefficient * pow(2, $maxPower - $i);
    }

    return $output;
}

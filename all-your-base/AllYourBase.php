<?php

declare(strict_types=1);

function rebase(int $originBase, array $sequence, int $base)
{
    if ($originBase <= 1 || $base <= 1 || count($sequence) === 0) return null;
    if (array_sum($sequence) === 0) return null;
    if ($sequence[0] === 0) return null;

    $numInDec = 0;

    foreach ($sequence as $i => $coefficient) {
        if ($coefficient < 0 || $coefficient >= $originBase) return null;

        $numInDec += $coefficient * pow($originBase, count($sequence) - 1 - $i);
    }

    if ($base == 10) {
        return array_map(fn ($num) => (int) $num, str_split((string) $numInDec));
    }

    $output = [];

    while ($numInDec >= $base) {
        array_unshift($output, $numInDec % $base);
        $numInDec = (int)($numInDec / $base);
    }

    array_unshift($output, $numInDec);

    return $output;
}

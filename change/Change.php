<?php

declare(strict_types=1);

/**
 * @param int[] $coins
 * @param int $amount
 */
function findFewestCoins(array $coins, int $amount): array
{
    if ($amount < 0) {
        throw new InvalidArgumentException('Cannot make change for negative value');
    }

    if ($amount === 0) {
        return [];
    }

    sort($coins);

    if ($coins[0] > $amount) {
        throw new InvalidArgumentException('No coins small enough to make change');
    }

    /**
     * list all possible combinations 
     * 
     * [
     *      possibleAmount => fewestCoins
     * ]
     */
    $changes = [
        0 => []
    ];

    foreach (range(0, $amount) as $i) {
        if (!array_key_exists($i, $changes)) {
            continue;
        }

        foreach ($coins as $coin) {
            $changeAmount = $i + $coin;

            $currentChange = [...$changes[$i], $coin];

            if (!isset($changes[$changeAmount]) || count($currentChange) < count($changes[$changeAmount])) {
                $changes[$changeAmount] = $currentChange;
            }
        }
    }

    if (!isset($changes[$amount])) {
        throw new InvalidArgumentException('No combination can add up to target');
    }

    return $changes[$amount];
}

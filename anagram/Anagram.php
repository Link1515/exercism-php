<?php

declare(strict_types=1);

function detectAnagrams(string $word, array $anagrams): array
{
    $targetArr = mb_str_split(mb_strtolower($word));
    sort($targetArr);


    $output = [];
    foreach ($anagrams as $anagram) {
        if (
            mb_strtolower($anagram) === mb_strtolower($word) ||
            in_array(mb_strtolower($anagram), array_map('mb_strtolower', $output))
        ) continue;

        $anagramArr = mb_str_split(mb_strtolower($anagram));
        sort($anagramArr);

        if ($targetArr === $anagramArr) {
            $output[] = $anagram;
        }
    }

    return $output;
}

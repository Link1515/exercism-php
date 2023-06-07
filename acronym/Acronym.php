<?php

declare(strict_types=1);

function acronym(string $text): string
{
    $text = preg_replace("/(\p{Ll})(\p{Lu})/u", "$1 $2", $text);

    $textArr = preg_split("/[\s|\-]/", $text);

    if (count($textArr) === 1) return '';

    return join(array_map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)), $textArr));
}

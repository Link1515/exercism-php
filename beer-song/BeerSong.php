<?php

declare(strict_types=1);

class BeerSong
{
    public function verse(int $number): string
    {
        switch ($number) {
            case 0:
                return "No more bottles of beer on the wall, no more bottles of beer.\n" .
                    "Go to the store and buy some more, 99 bottles of beer on the wall.";

            case 1:
                return "1 bottle of beer on the wall, 1 bottle of beer.\n" .
                    "Take it down and pass it around, no more bottles of beer on the wall.\n";

            case 2:
                return "2 bottles of beer on the wall, 2 bottles of beer.\n" .
                    "Take one down and pass it around, 1 bottle of beer on the wall.\n";

            default:
                return $number . " bottles of beer on the wall, " . $number . " bottles of beer.\n" .
                    "Take one down and pass it around, " . $number - 1 . " bottles of beer on the wall.\n";
        }
    }

    public function verses(int $start, int $finish): string
    {
        $output = [];

        foreach (range($start, $finish) as $number) {
            $output[] = $this->verse($number);
        }

        return implode("\n", $output);
    }

    public function lyrics(): string
    {
        return $this->verses(99, 0);
    }
}

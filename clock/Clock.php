<?php

declare(strict_types=1);

class Clock
{
    private int $hours;
    private int $minutes;

    public function __construct(int $hours, int $minutes = 0)
    {
        $totalAddMinutes = $hours * 60 + $minutes;

        $calculatedTime = $this->calculate([0, 0], $totalAddMinutes);

        $this->hours = $calculatedTime[0];
        $this->minutes = $calculatedTime[1];
    }

    public function add($minutes): self
    {
        $calculatedTime = $this->calculate([$this->hours, $this->minutes], $minutes);

        return new self($calculatedTime[0], $calculatedTime[1]);
    }

    public function sub($minutes): self
    {
        $calculatedTime = $this->calculate([$this->hours, $this->minutes], -$minutes);

        return new self($calculatedTime[0], $calculatedTime[1]);
    }

    private function calculate(array $input, int $totalAddMinutes): array
    {
        $output = &$input;

        $hours = (int) ($totalAddMinutes / 60);
        $minutes =  $totalAddMinutes % 60;

        $output[1] += $minutes;

        if ($output[1] >= 60) {
            $output[1] -= 60;
            $hours++;
        } else if ($output[1] < 0) {
            $output[1] += 60;
            $hours--;
        }

        if ($hours !== 0) {
            $output[0] += (24 + $hours % 24);
            $output[0] %= 24;
        }

        return $output;
    }

    public function __toString(): string
    {
        return
            str_pad((string) $this->hours, 2, "0", STR_PAD_LEFT) .
            ":" .
            str_pad((string) $this->minutes, 2, "0", STR_PAD_LEFT);
    }
}

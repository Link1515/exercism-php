<?php

declare(strict_types=1);
/**  
 * @property int $frame
 * @property int $round
 * @property int $currentScore
 * @property Score[] $scores 
 */
class Game
{
    private int $frame = 0;
    private array $scores = [];
    public function roll(int $pins): void
    {
        if ($pins < 0) {
            throw new Exception("score can not less than 0");
        }
        if ($pins > 10) {
            throw new Exception("score can not greater than 10");
        }
        $this->checkBounsFrame();
        if (isset($this->scores[$this->frame])) {
            $this->scores[$this->frame]->setSecondScore($pins);
        } else {
            $this->scores[$this->frame] = new Score($pins);
        }
        if ($this->scores[$this->frame]->isFinish()) {
            $this->frame++;
        }
    }
    private function checkBounsFrame()
    {
        if ($this->frame === 10) {
            if (!($this->scores[9]->getFlag() === Score::STRIKE) && !($this->scores[9]->getFlag() === Score::SPARE)) {
                throw new Exception("frame error");
            }
        } else if ($this->frame === 11) {
            if (!($this->scores[9]->getFlag() === Score::STRIKE)) {
                throw new Exception("frame error");
            }
        } else if ($this->frame > 11) {
            throw new Exception("frame error");
        }
    }
    public function score(): int
    {
        if ($this->frame <= 9) {
            throw new Exception("game is not finished");
        }
        $sum = 0;
        foreach ($this->scores as $frame => $score) {
            if ($frame > 9) {
                break;
            }
            $sum += array_sum($score->getScores());
            switch ($score->getFlag()) {
                case Score::STRIKE:
                    $sum += $this->getStrikeAdditionalScore($frame);
                    break;
                case Score::SPARE:
                    $sum += $this->getSpareAdditionalScore($frame);
                    break;
            }
        }
        return $sum;
    }
    private function getSpareAdditionalScore(int $frame): int
    {
        if (!isset($this->scores[$frame + 1])) {
            throw new Exception("frame error");
        }
        return $this->scores[$frame + 1]->getScores()[0];
    }
    private function getStrikeAdditionalScore(int $frame): int
    {
        if (!isset($this->scores[$frame + 1])) {
            throw new Exception("frame error");
        }
        $addtionalScore = $this->scores[$frame + 1]->getScores()[0];
        if ($this->scores[$frame + 1]->getFlag() === Score::STRIKE) {
            if (!isset($this->scores[$frame + 2])) {
                throw new Exception("frame error");
            }
            $addtionalScore += $this->scores[$frame + 2]->getScores()[0];
        } else {
            if (!isset($this->scores[$frame + 1]->getScores()[1])) {
                throw new Exception("frame error");
            }
            $addtionalScore += $this->scores[$frame + 1]->getScores()[1];
        }
        return $addtionalScore;
    }
}
class Score
{
    const STRIKE = "STRIKE";
    const SPARE = "SPARE";
    private int $first = 0;
    private int $second = 0;
    private ?string $flag = null;
    private bool $finish = false;
    public function __construct(int $firstScore)
    {
        $this->first = $firstScore;
        if ($firstScore === 10) {
            $this->flag = self::STRIKE;
            $this->finish = true;
        }
    }
    public function setSecondScore(int $secondScore)
    {
        $this->second = $secondScore;
        if ($this->first + $this->second > 10) {
            throw new Exception("score can not greater than 10");
        }
        if ($this->first + $this->second === 10) {
            $this->flag = self::SPARE;
        }
        $this->finish = true;
    }
    public function getScores(): array
    {
        return [$this->first, $this->second];
    }
    public function isFinish(): bool
    {
        return $this->finish;
    }
    public function getFlag()
    {
        return $this->flag;
    }
}

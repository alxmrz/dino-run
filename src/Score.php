<?php

namespace DR;

use PsyXEngine\GameObject;
use PsyXEngine\Text;
use SDL2\SDLColor;

class Score extends GameObject
{
    public int $value = 0;

    public function __construct(int $x, int $y, int $width, int $height)
    {
        $this->renderType = new Text($x, $y, $width, $height, new SDLColor(255, 0, 0, 0), "Score: " . $this->value);
    }

    public function add(int $value): void
    {
        $this->value += $value;

        $this->renderType->setText("Score: " . $this->value);
    }

    public function reset(): void
    {
        $this->value = 0;
    }
}
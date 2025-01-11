<?php

declare(strict_types=1);

namespace DR;

use PsyXEngine\GameObject;
use PsyXEngine\Rectangle;
use SDL2\SDLColor;

class GroundLine extends GameObject
{
    public $x;
    public $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
        
        $this->renderType = new Rectangle($x, $y, 900, 10, new SDLColor(0, 255, 0, 0));
    }
}

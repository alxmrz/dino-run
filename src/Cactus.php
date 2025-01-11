<?php

declare(strict_types=1);

namespace DR;

use PsyXEngine\Collision;
use PsyXEngine\GameObject;
use PsyXEngine\Image;
use SDL2\SDLRect;

class Cactus extends GameObject
{
    public $x;
    public $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function update(): void
    {
        $this->x -= 5;
        $this->renderNewPosition();
        if ($this->x < 10) {
            $this->destroy();
        }
    }

    private function renderNewPosition(): void
    {
        $this->renderType = new Image(
            __DIR__ . '/../assets/cactus.png',
            new SDLRect($this->x, $this->y, 25, 50)
        );

        $this->collision = new Collision($this->x+5, $this->y, 15, 50);
    }

    public function isMovable(): bool
    {
        return true;
    }

}

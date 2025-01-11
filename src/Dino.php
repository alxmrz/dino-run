<?php

declare(strict_types=1);

namespace DR;

use PsyXEngine\Collision;
use PsyXEngine\GameObject;
use PsyXEngine\GameObjects;
use PsyXEngine\Image;
use PsyXEngine\KeyPressedEvent;
use SDL2\SDLRect;

class Dino extends GameObject
{
    private int $x = 0;
    private int $y = 0;
    private bool $collided = false;

    private int $groundLineYCoord = 300;

    private int $jumpOffset = 0;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;

        $this->renderNewPosition();
    }

    public function isCollided(): bool
    {
        return $this->collided;
    }

    private function renderNewPosition(): void
    {
        $this->renderType = new Image(
            __DIR__ . '/../assets/dino.png',
            new SDLRect($this->x, $this->y, 50, 100)
        );

        $this->collision = new Collision($this->x, $this->y, 50, 100);
    }

    public function update(): void
    {
        if ($this->isJumping()) {
            $this->jumpOffset -= 10;
            $this->y -= 10;

            $this->renderNewPosition();
        } else {
            $this->gravitate();
        }
    }

    private function gravitate(): void
    {
        if (!$this->isOnGround()) {
            echo "Y: $this->y, GY: $this->groundLineYCoord \n";
            $this->y += 10;

            $this->renderNewPosition();
        }
    }

    private function isOnGround(): bool
    {
        return $this->y >= $this->groundLineYCoord;
    }

    public function onButtonPressed(KeyPressedEvent $event, GameObjects $gameObjects): void
    {
        if ($event->isSpacePressed() && $this->isOnGround() ) {
            $this->jumpOffset = 200;
        }
    }

    public function isJumping(): bool
    {
        return $this->jumpOffset > 0;
    }

    public function getYCoord(): int
    {
        return $this->y;
    }

    public function onCollision(GameObject $gameObject, GameObjects $gameObjects): void
    {
        if ($gameObject instanceof Cactus) {
            $this->collided = true;
        }
    }

    public function isMovable(): bool
    {
        return true;
    }
}

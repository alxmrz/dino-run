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

    private int $groundLineYCoord;

    private int $jumpOffset = 0;

    public function __construct(int $x, int $y, int $groundYLineCoord = 300)
    {
        $this->x = $x;
        $this->y = $y;

        $this->groundLineYCoord = $groundYLineCoord;

        $this->renderNewPosition();
    }

    public function moveToPosition(int $x, int $y): void
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function isCollided(): bool
    {
        return $this->collided;
    }

    public function moveToGround(): void
    {
        $this->y = $this->groundLineYCoord;
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

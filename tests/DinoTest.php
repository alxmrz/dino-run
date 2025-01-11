<?php

namespace DR\Tests;

use DR\Dino;
use PHPUnit\Framework\TestCase;
use PsyXEngine\GameObjects;
use PsyXEngine\KeyPressedEvent;
use SDL2\KeyCodes;

class DinoTest extends TestCase
{
    private Dino $dino;

    public function setUp(): void
    {
        $this->dino = new Dino(50, 100, 100);
    }

    public function testOnButtonPressed()
    {
        $go = new GameObjects();
        $event = new KeyPressedEvent(KeyCodes::SDLK_SPACE);

        $this->dino->onButtonPressed($event, $go);

        $this->assertTrue($this->dino->isJumping());
    }

    public function testChangeYCoordOnUpdateWhenJumping()
    {
        $go = new GameObjects();
        $event = new KeyPressedEvent(KeyCodes::SDLK_SPACE);

        $this->dino->update();
        $this->assertEquals(100, $this->dino->getYCoord());

        $this->dino->onButtonPressed($event, $go);

        $this->dino->update();
        $this->assertEquals(90, $this->dino->getYCoord());
    }

    public function testGravityOnEveryUpdate(): void
    {
        $this->dino = new Dino(50, 50, 100);

        $this->dino->update();
        $this->assertEquals(60, $this->dino->getYCoord());

        $this->dino->update();
        $this->assertEquals(70, $this->dino->getYCoord());

        $this->dino->update();
        $this->assertEquals(80, $this->dino->getYCoord());
    }
}

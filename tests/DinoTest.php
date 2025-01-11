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
        $this->dino = new Dino(50, 50);
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
        $this->assertEquals(55, $this->dino->getYCoord());

        $this->dino->onButtonPressed($event, $go);

        $this->dino->update();
        $this->assertEquals(45, $this->dino->getYCoord());
    }

    public function testJumpStopedWhenOffsetDone()
    {
        $go = new GameObjects();
        $event = new KeyPressedEvent(KeyCodes::SDLK_SPACE);

        $this->dino->onButtonPressed($event, $go);

        $this->dino->update();
        $this->assertEquals(40, $this->dino->getYCoord());
        $this->assertTrue($this->dino->isJumping());

        $this->dino->update();
        $this->assertEquals(30, $this->dino->getYCoord());
        $this->assertFalse($this->dino->isJumping());
    }

    public function testGravityOnEveryUpdate(): void
    {
        $this->dino->update();
        $this->assertEquals(55, $this->dino->getYCoord());

        $this->dino->update();
        $this->assertEquals(60, $this->dino->getYCoord());

        $this->dino->update();
        $this->assertEquals(65, $this->dino->getYCoord());
    }
}

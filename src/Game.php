<?php

namespace DR;

use PsyXEngine\Event;
use PsyXEngine\GameInterface;
use PsyXEngine\GameObjects;

class Game implements GameInterface
{
    private int $start = 0;
    private float $timer = 0;
    private int $createAfter = 0;
    private GameObjects $gameObjects;
    private Dino $dino;
    private GroundLine $gl;
    private Score $score;
    public function init(GameObjects $gameObjects): void
    {
        $this->start = $this->passedMillisecs();
        $this->createAfter = mt_rand(100, max: 1000);
        $this->gameObjects = $gameObjects;

        $this->gl = new GroundLine(0, 400);
        
        $gameObjects->add($this->gl);

        $this->initGame();
    }

    private function passedMillisecs(): float
    {
        return round (microtime(true) * 1000);
    }

    private function initGame(): void
    {
        $this->dino = new Dino(100, 300);
        $this->score = new Score(0, 0, 100, 50);
        $this->gameObjects->exchangeArray([$this->dino, $this->gl, $this->score]);
    }

    public function update(?Event $event = null): void
    {
        if ($this->dino->isCollided()) {
            $this->initGame();
        }
        $end = $this->passedMillisecs();

        $this->timer += $end - $this->start; //millisecs
        $this->start = $end;

        if ((int)$this->timer > $this->createAfter) {
            $this->timer = 0;
            $this->createAfter = mt_rand(500, max: 2000);
            $this->gameObjects->add(new Cactus(900, 350));
        }

        $this->score->add(value: 1);
    }
}

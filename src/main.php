<?php

declare(strict_types=1);

use DR\Game;
use PsyXEngine\Engine;

require_once __DIR__ . '/../vendor/autoload.php';

$engine = new Engine();

$engine->setWindowTitle('Run, Dino, run');
$engine->setWindowWidth(900);
$engine->setWindowHeight(600);

$engine->run(new Game());
<?php

declare(strict_types = 1);

namespace BlockHorizons\MazeGenerator;

use BlockHorizons\MazeGenerator\generators\TestGenerator;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

	public function onEnable(): void {
		$maze = new TestGenerator(new Vector3(100, 100, 100), new Vector3(116, 102, 116));
		$maze->generate($this->getServer()->getDefaultLevel(), Block::get(Block::STONE));
	}
}
<?php

declare(strict_types = 1);

namespace BlockHorizons\MazeGenerator;

use BlockHorizons\MazeGenerator\generators\TestGenerator;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

	public function onEnable(): void {
	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
		if(count($args) !== 6) {
			return false;
		}

		foreach($args as $key => &$arg) {
			if($arg{0} === "~") {
				$arg = (int) substr($arg, 1);
				switch($key % 3) {
					case 0:
						$arg += $sender->getFloorX();
						break;
					case 1:
						$arg += $sender->getFloorY();
						break;
					case 2:
						$arg += $sender->getFloorZ();
						break;
				}
			}

			$arg = (int) $arg;
		}

		[$x1, $y1, $z1, $x2, $y2, $z2] = $args;

		$wall = $sender->getInventory()->getItemInHand()->getBlock();
		if($wall->getId() === Block::AIR) {
			$wall = Block::get(Block::STONE);
		}

		$sender->sendMessage("Generating maze (wall: " . $wall->getName() . ")...");
		$maze = new TestGenerator(new Vector3($x1, $y1, $z1), new Vector3($x2, $y2, $z2));
		$maze->generate($wall, $this->getServer()->getDefaultLevel());
		$sender->sendMessage("Maze generated!");
		return true;
	}
}
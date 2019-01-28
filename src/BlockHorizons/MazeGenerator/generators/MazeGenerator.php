<?php

declare(strict_types = 1);

namespace BlockHorizons\MazeGenerator\generators;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\math\Vector3;

abstract class MazeGenerator {

	/** @var int */
	protected $minX;

	/** @var int */
	protected $maxX;

	/** @var int */
	protected $minY;

	/** @var int */
	protected $maxY;

	/** @var int */
	protected $minZ;

	/** @var int */
	protected $maxZ;

	public function __construct(Vector3 $pos1, Vector3 $pos2) {
		$this->minX = min($pos1->getFloorX(), $pos2->getFloorX());
		$this->maxX = max($pos1->getFloorX(), $pos2->getFloorX());
		$this->minY = min($pos1->getFloorY(), $pos2->getFloorY());
		$this->maxY = max($pos1->getFloorY(), $pos2->getFloorY());
		$this->minZ = min($pos1->getFloorZ(), $pos2->getFloorZ());
		$this->maxZ = max($pos1->getFloorZ(), $pos2->getFloorZ());

		$this->validateBounds();
	}

	protected function validateBounds(): void {
		if($this->maxX === $this->minX) {
			throw new \LengthException("minX cannot be equal to maxX");
		}

		if($this->maxY === $this->minY) {
			throw new \LengthException("minY cannot be equal to maxY");
		}

		if($this->maxZ === $this->minZ) {
			throw new \LengthException("minZ cannot be equal to maxZ");
		}
	}

	public function getXLength(): int {
		return $this->maxX - $this->minX;
	}

	public function getYLength(): int {
		return $this->maxY - $this->minY;
	}

	public function getZLength(): int {
		return $this->maxZ - $this->minZ;
	}

	public function generate(Block $wall_block, Level $level): void {
		$pos = new Vector3();
		foreach($this->generateTerrain() as $result) {
			$pos->x = $this->minX + $result->x;
			$pos->z = $this->minZ + $result->z;
			for($pos->y = $this->minY; $pos->y <= $this->maxY; ++$pos->y) {
				$level->setBlock($pos, $result->is_wall ? $wall_block : Block::get(Block::AIR), false, false);
			}
		}
	}

	abstract public function generateTerrain(): \Generator;
}
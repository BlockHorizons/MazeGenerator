<?php

declare(strict_types = 1);

namespace BlockHorizons\MazeGenerator\generators;

class GenerationResult {

	/** @var int */
	public $x;

	/** @var int */
	public $z;

	/** @var bool */
	public $is_wall;

	public function __construct(int $x, int $z, bool $is_wall) {
		$this->x = $x;
		$this->z = $z;
		$this->is_wall = $is_wall;
	}
}
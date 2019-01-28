<?php

declare(strict_types = 1);

namespace BlockHorizons\MazeGenerator\generators;

//Source: https://github.com/yandod/php-maze

class TestGenerator extends MazeGenerator {

	public function generateTerrain(): \Generator {
		$xlen = $this->getXLength();
		$zlen = $this->getZLength();

		for($x = 0; $x < $xlen; ++$x) {
			for($z = 0; $z < $zlen; ++$z) {
				$field[$x][$z] = true;
			}
		}

		foreach($this->iterate($field, 0, 0, $xlen, $zlen) as $x => $fields) {
			foreach($fields as $z => $is_wall) {
				yield new GenerationResult($x, $z, $is_wall);
			}
		}
	}

	public function iterate(array $field, int $x, int $z, int $xlen, int $zlen): array {
		$field[$x][$z] = false;
		while(true) {
			$directions = [];

			if($x > 1 && $field[$x - 2][$z]) {
				$directions[] = [-1, 0];
			}

			if($x < $xlen - 2 && $field[$x + 2][$z]) {
				$directions[] = [1, 0];
			}

			if($z > 1 && $field[$x][$z - 2]) {
				$directions[] = [0, -1];
			}

			if($z < $zlen - 2 && $field[$x][$z + 2]) {
				$directions[] = [0, 1];
			}

			if(empty($directions)) {
				return $field;
			}

			$dir = $directions[(int) floor(lcg_value() * count($directions))];
			$field[$x + $dir[0]][$z + $dir[1]] = false;
			$field = $this->iterate($field, $x + $dir[0] * 2, $z + $dir[1] * 2, $xlen, $zlen);
		}
	}
}
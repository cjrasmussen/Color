<?php

namespace cjrasmussen\Color\ColorType;

use InvalidArgumentException;

class Hsl
{
	public int $H;
	public float $S;
	public float $L;

	public function __construct(int $h, float $s, float $l)
	{
		if (($h < 0) || ($h > 359)) {
			$msg = '"H" value is expected to be between 0 and 360, "' . $h . '" provided';
			throw new InvalidArgumentException($msg);
		}

		if (($s < 0) || ($s > 1)) {
			$msg = '"S" value is expected to be between 0 and 1, "' . $s . '" provided';
			throw new InvalidArgumentException($msg);
		}

		if (($l < 0) || ($l > 1)) {
			$msg = '"L" value is expected to be between 0 and 1, "' . $l . '" provided';
			throw new InvalidArgumentException($msg);
		}

		$this->H = $h;
		$this->S = round($s, 5);
		$this->L = round($l, 5);
	}

	/**
	 * Convert HSL color to RGB
	 *
	 * @return Rgb
	 * @see https://www.rapidtables.com/convert/color/hsl-to-rgb.html
	 */
	public function toRgb(): Rgb
	{
		$c = (1 - abs((2 * $this->L) - 1)) * $this->S;
		$h = $this->H / 60;
		$x = $c * (1 - abs(fmod($h, 2) - 1));

		$r = $g = $b = 0;

		if (($h >= 0) && ($h < 1)) {
			$r = $c;
			$g = $x;
		} elseif (($h >= 1) && ($h < 2)) {
			$r = $x;
			$g = $c;
		} elseif (($h >= 2) && ($h < 3)) {
			$g = $c;
			$b = $x;
		} elseif (($h >= 3) && ($h < 4)) {
			$g = $x;
			$b = $c;
		} elseif (($h >= 4) && ($h < 5)) {
			$r = $x;
			$b = $c;
		} else {
			$r = $c;
			$b = $x;
		}

		$t = $this->L - ($c / 2);

		$r = (int)round(($r + $t) * 255);
		$g = (int)round(($g + $t) * 255);
		$b = (int)round(($b + $t) * 255);

		return new Rgb($r, $g, $b);
	}
}
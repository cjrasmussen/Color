<?php

namespace cjrasmussen\Color\ColorType;

use InvalidArgumentException;

class Rgb
{
	public int $R;
	public int $G;
	public int $B;

	public function __construct(int $r, int $g, int $b)
	{
		if (($r < 0) || ($r > 255)) {
			$msg = '"R" value is expected to be between 0 and 255, "' . $r . '" provided';
			throw new InvalidArgumentException($msg);
		}

		if (($g < 0) || ($g > 255)) {
			$msg = '"G" value is expected to be between 0 and 255, "' . $g . '" provided';
			throw new InvalidArgumentException($msg);
		}

		if (($b < 0) || ($b > 255)) {
			$msg = '"B" value is expected to be between 0 and 255, "' . $b . '" provided';
			throw new InvalidArgumentException($msg);
		}

		$this->R = $r;
		$this->G = $g;
		$this->B = $b;
	}

	/**
	 * Convert RGB color to Hexadecimal string
	 *
	 * @return string
	 */
	public function toHex(): string
	{
		return str_pad(dechex($this->R), 2, '0', STR_PAD_LEFT) . str_pad(dechex($this->G), 2, '0', STR_PAD_LEFT) . str_pad(dechex($this->B), 2, '0', STR_PAD_LEFT);
	}

	/**
	 * Convert RGB color to HSL
	 *
	 * @return Hsl
	 * @see https://pastebin.com/3xKsi7SD
	 */
	public function toHsl(): Hsl
	{
		$r = $this->R / 255;
		$g = $this->G / 255;
		$b = $this->B / 255;

		$max = max($r, $g, $b);
		$min = min($r, $g, $b);
		$combined = $max + $min;

		$h = $s = 0.0;
		$l = $combined / 2;

		if ($max === $min) {
			return new Hsl($h, $s, $l);
		}

		$diff = $max - $min;

		if ($l < .5) {
			$s = ($diff / $combined);
		} else {
			$s = ($diff / (2.0 - $max - $min));
		}

		switch ($max) {
			case $r:
				$h = (($g - $b) / $diff);
				break;
			case $g:
				$h = 2.0 + (($b - $r) / $diff);
				break;
			case $b:
				$h = 4.0 + (($r - $g) / $diff);
				break;
		}

		$h *= 60;

		return new Hsl((int)round($h), $s, $l);
	}

	/**
	 * Convert RGB color to HSV
	 *
	 * @return Hsv
	 */
	public function toHsv(): Hsv
	{
		$r = $this->R / 255;
		$g = $this->G / 255;
		$b = $this->B / 255;

		$max = max($r, $g, $b);
		$min = min($r, $g, $b);

		$diff = $max - $min;

		if ($diff === 0) {
			$h = 0;
		} elseif ($max === $r) {
			$h = fmod((($g - $b) / $diff), 6);
		} elseif ($max === $g) {
			$h = (($b - $r) / $diff) + 2;
		} else {
			$h = (($r - $g) / $diff) + 4;
		}

		$h *= 60;
		if ($h < 0) {
			$h += 360;
		}

		$v = $max;

		if ($v === 0) {
			$s = 0;
		} else {
			$s = $diff / $v;
		}

		return new Hsv((int)round($h), $s, $v);
	}

	/**
	 * Calculate the luminance of an RGB color
	 *
	 * @return float
	 * @see https://stackoverflow.com/questions/9733288/how-to-programmatically-calculate-the-contrast-ratio-between-two-colors
	 */
	public function getLuminance(): float
	{
		$luminance = static function ($v) {
			$v /= 255;
			return ($v < 0.03928) ? ($v / 12.92) : ((($v + 0.055) / 1.055) ** 2.4);
		};

		return round((($luminance($this->R) * 0.2126) + ($luminance($this->G) * 0.7152) + ($luminance($this->B) * 0.0722)), 5);
	}
}
<?php
namespace cjrasmussen\Color;

use stdClass;

class Convert
{
	/**
	 * Convert a hexidecimal color to RGB
	 *
	 * @param string $hex
	 * @return stdClass
	 */
	public static function hexToRgb($hex): stdClass
	{
		if (strlen($hex) <= 3) {
			$hex = $hex{0} . $hex{0} . $hex{1} . $hex{1} . $hex{2} . $hex{2};
		}

		[$r, $g, $b] = str_split($hex, 2);
		return (object)['R' => hexdec($r), 'G' => hexdec($g), 'B' => hexdec($b)];
	}

	/**
	 * Convert RGB color to hexidecimal
	 *
	 * First parameter can be the value of red or an object representing all three attributes
	 *
	 * @param int|stdClass $mixed
	 * @param int|null $g
	 * @param int|null $b
	 * @return string
	 */
	public static function rgbToHex($mixed, $g = null, $b = null): string
	{
		if ($mixed instanceof stdClass) {
			$r = $mixed->R;
			$g = $mixed->G;
			$b = $mixed->B;
		} else {
			$r = (int)$mixed;
		}

		return str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
	}

	/**
	 * Convert RGB color to HSL
	 *
	 * First parameter can be the value of red or an object representing all three attributes
	 *
	 * @param int|stdClass $mixed
	 * @param int|null $g
	 * @param int|null $b
	 * @return string
	 */
	public static function rgbToHsl($mixed, $g = null, $b = null): stdClass
	{
		if ($mixed instanceof stdClass) {
			$r = $mixed->R;
			$g = $mixed->G;
			$b = $mixed->B;
		} else {
			$r = (int)$mixed;
		}

		$r /= 255;
		$g /= 255;
		$b /= 255;

		$max = max($r, $g, $b);
		$min = min($r, $g, $b);

		$l = ($max + $min) / 2;

		if ($max === $min) {
			$h = $s = 0;
		} else {
			if ($b === $max) {
				$h = 4 + (($r - $g) / ($max - $min));
			} elseif ($g === $max) {
				$h = 2 + (($b - $r) / ($max - $min));
			} else {
				$h = (($g - $b) / ($max - $min));
			}

			$h *= 60;

			if ($l < .5) {
				$s = (($max - $min) / ($max + $min));
			} else {
				$s = (($max - $min) / (2 - $max - $min));
			}
		}

		return (object)['H' => (int)round($h), 'S' => $s, 'L' => $l];
	}

	/**
	 * Convert HSL color to RGB
	 *
	 * First parameter can be the value of hue or an object representing all three attributes
	 *
	 * @param int|stdClass $mixed
	 * @param float|null $s
	 * @param float|null $l
	 * @return stdClass
	 */
	public static function hslToRgb($mixed, $s = null, $l = null): stdClass
	{
		if ($mixed instanceof stdClass) {
			$h = $mixed->H;
			$s = $mixed->S;
			$l = $mixed->L;
		} else {
			$h = (int)$mixed;
		}

		if ($s === 0) {
			$r = $g = $b = (int)round(255 * $l);
			return (object)['R' => $r, 'G' => $g, 'B' => $b];
		}

		if ($l < .5) {
			$t1 = ($l * (1 + $s));
		} else {
			$t1 = ($l + $s - ($l * $s));
		}
		$t2 = ((2 * $l) - $t1);

		$h /= 360;

		$convert = static function ($ct) use ($t1, $t2) {
			if ($ct < 0) {
				$ct++;
			} elseif ($ct > 1) {
				$ct--;
			}

			if ((6 * $ct) < 1) {
				return ($t2 + (($t1 - $t2) * 6 * $ct));
			}

			if ((2 * $ct) < 1) {
				return $t1;
			}

			if ((3 * $ct) < 2) {
				return ($t2 + (($t1 - $t2) * ((2 / 3) - $ct) * 6));
			}

			return $t2;
		};

		$r = $convert($h + (1 / 3));
		$g = $convert($h);
		$b = $convert($h - (1 / 3));

		$r = (int)round($r * 255);
		$g = (int)round($g * 255);
		$b = (int)round($b * 255);

		return (object)['R' => $r, 'G' => $g, 'B' => $b];
	}

	/**
	 * Accepts a hexidecimal string or HSL class and convers it to an RGB class
	 *
	 * @param stdClass|string $mixed
	 * @return stdClass|null
	 */
	public static function inputToRgb($mixed): ?stdClass
	{
		if ($mixed instanceof stdClass) {
			if ($mixed->H) {
				$mixed = self::hslToRgb($mixed);
			}

			if (isset($mixed->R)) {
				return $mixed;
			}
		} else {
			return self::hexToRgb($mixed);
		}

		return null;
	}
}

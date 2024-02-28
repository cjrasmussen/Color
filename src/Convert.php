<?php

namespace cjrasmussen\Color;

class Convert
{
	/**
	 * Convert a hexadecimal color to RGB
	 *
	 * @param string $hex
	 * @return object
	 */
	public static function hexToRgb(string $hex): object
	{
		if (strlen($hex) <= 3) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}

		[$r, $g, $b] = str_split($hex, 2);
		return (object)['R' => hexdec($r), 'G' => hexdec($g), 'B' => hexdec($b)];
	}

	/**
	 * Convert RGB color to hexadecimal
	 *
	 * First parameter can be the value of red or an object representing all three attributes
	 *
	 * @param int|object $mixed
	 * @param int|null $g
	 * @param int|null $b
	 * @return string
	 */
	public static function rgbToHex($mixed, ?int $g = null, ?int $b = null): string
	{
		if (is_object($mixed)) {
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
	 * @param int|object $mixed
	 * @param int|null $g
	 * @param int|null $b
	 * @return object
	 */
	public static function rgbToHsl($mixed, ?int $g = null, ?int $b = null): object
	{
		if (is_object($mixed)) {
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

		$diff = $max - $min;

		if ($max === $min) {
			$h = $s = 0;
		} else {
			if ($b === $max) {
				$h = 4 + (($r - $g) / $diff);
			} elseif ($g === $max) {
				$h = 2 + (($b - $r) / $diff);
			} else {
				$h = (($g - $b) / $diff);
			}

			$h *= 60;

			if ($l < .5) {
				$s = ($diff / ($max + $min));
			} else {
				$s = ($diff / (2 - $diff));
			}
		}

		return (object)['H' => (int)round($h), 'S' => $s, 'L' => $l];
	}

	/**
	 * Convert HSL color to RGB
	 *
	 * First parameter can be the value of hue or an object representing all three attributes
	 *
	 * @param int|object $mixed
	 * @param float|null $s
	 * @param float|null $l
	 * @return object
	 */
	public static function hslToRgb($mixed, ?float $s = null, ?float $l = null): object
	{
		if (is_object($mixed)) {
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
	 * Accepts a hexadecimal string or HSL class and converts it to an RGB class
	 *
	 * @param object|string $mixed
	 * @return object|null
	 */
	public static function inputToRgb($mixed): ?object
	{
		if (is_object($mixed)) {
			if (isset($mixed->H)) {
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

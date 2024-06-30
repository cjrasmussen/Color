<?php

namespace cjrasmussen\Color;

use cjrasmussen\Color\ColorType\Hex;
use cjrasmussen\Color\ColorType\Hsl;
use cjrasmussen\Color\ColorType\Hsv;
use cjrasmussen\Color\ColorType\Rgb;
use InvalidArgumentException;

class General
{
	/**
	 * Determine if two colors contrast each other
	 *
	 * @param object|string $color1
	 * @param object|string $color2
	 * @param int $threshold
	 * @return bool
	 */
	public static function doColorsContrast($color1, $color2, int $threshold = 4): bool
	{
		$contrast = self::calculateColorContrast($color1, $color2);
		return ($contrast > $threshold);
	}

	/**
	 * Calculate the amount of contrast between two colors
	 *
	 * @param Rgb|Hex|Hsl|Hsv|string $color1
	 * @param Rgb|Hex|Hsl|Hsv|string $color2
	 * @return float
	 * @see https://stackoverflow.com/questions/9733288/how-to-programmatically-calculate-the-contrast-ratio-between-two-colors
	 */
	public static function calculateColorContrast($color1, $color2): float
	{
		if (is_string($color1)) {
			$color1 = new Hex($color1);
		}

		if (is_string($color2)) {
			$color2 = new Hex($color2);
		}

		if (($color1 instanceof Hex) || ($color1 instanceof Hsl) || ($color1 instanceof Hsv)) {
			$rgb1 = $color1->toRgb();
		} elseif ($color1 instanceof Rgb) {
			$rgb1 = $color1;
		} else {
			throw new InvalidArgumentException();
		}

		if (($color2 instanceof Hex) || ($color2 instanceof Hsl) || ($color2 instanceof Hsv)) {
			$rgb2 = $color2->toRgb();
		} elseif ($color2 instanceof Rgb) {
			$rgb2 = $color2;
		} else {
			throw new InvalidArgumentException();
		}

		$lum1 = $rgb1->getLuminance();
		$lum2 = $rgb2->getLuminance();

		$bright = max($lum1, $lum2);
		$dark = min($lum1, $lum2);

		return (($bright + 0.05) / ($dark + 0.05));
	}

	/**
	 * Determine if a string is a hexadecimal color
	 *
	 * @param string $string
	 * @return bool
	 */
	public static function isHexColor(string $string): bool
	{
		$length = strlen($string);
		return ((($length === 3) OR ($length === 6)) AND (ctype_xdigit($string)));
	}

	/**
	 * Remove extraneous characters from a string to make it a "clean" hexadecimal color
	 *
	 * @param string $string
	 * @return string
	 */
	public static function cleanHexColor(string $string): string
	{
		$string = trim($string, ' #;');
		return (self::isHexColor($string)) ? $string : '';
	}
}

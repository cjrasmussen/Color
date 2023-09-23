<?php
namespace cjrasmussen\Color;

use stdClass;

class General
{
	/**
	 * Determine if two colors contrast each other
	 *
	 * @param stdClass|string $color1
	 * @param stdClass|string $color2
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
	 * @param stdClass|string $color1
	 * @param stdClass|string $color2
	 * @return float
	 * @see https://stackoverflow.com/questions/9733288/how-to-programmatically-calculate-the-contrast-ratio-between-two-colors
	 */
	public static function calculateColorContrast($color1, $color2): float
	{
		$lum1 = self::calculateRgbLuminance(Convert::inputToRgb($color1));
		$lum2 = self::calculateRgbLuminance(Convert::inputToRgb($color2));

		$bright = max($lum1, $lum2);
		$dark = min($lum1, $lum2);

		return (($bright + 0.05) / ($dark + 0.05));
	}

	/**
	 * Calculate the luminance of an RGB color
	 *
	 * @param object $color
	 * @return float
	 * @see https://stackoverflow.com/questions/9733288/how-to-programmatically-calculate-the-contrast-ratio-between-two-colors
	 */
	public static function calculateRgbLuminance(object $color): float
	{
		$luminance = static function ($v) {
			$v /= 255;
			return ($v < 0.03928) ? ($v / 12.92) : ((($v + 0.055) / 1.055) ** 2.4);
		};

		return (($luminance($color->R) * 0.2126) + ($luminance($color->G) * 0.7152) + ($luminance($color->B) * 0.0722));
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

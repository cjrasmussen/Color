<?php

namespace cjrasmussen\Color\ColorType;

use cjrasmussen\Color\General;
use InvalidArgumentException;

class Hex
{
	public string $hexString;

	/**
	 * @param string|int $hex
	 */
	public function __construct($hex)
	{
		$hex = (string)$hex;

		$hex = General::cleanHexColor($hex);
		if (!General::isHexColor($hex)) {
			$msg = '"' . $hex . '" is not a valid hexadecimal color';
			throw new InvalidArgumentException($msg);
		}

		if (strlen($hex) === 3) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}

		$this->hexString = $hex;
	}

	public function __toString(): string
	{
		return $this->hexString;
	}

	/**
	 * Convert a hexadecimal color to RGB
	 *
	 * @return Rgb
	 */
	public function toRgb(): Rgb
	{
		[$r, $g, $b] = str_split($this->hexString, 2);
		return new Rgb(hexdec($r), hexdec($g), hexdec($b));
	}
}
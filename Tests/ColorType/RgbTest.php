<?php

namespace ColorType;

use cjrasmussen\Color\ColorType\Hex;
use cjrasmussen\Color\ColorType\Hsl;
use cjrasmussen\Color\ColorType\Hsv;
use cjrasmussen\Color\ColorType\Rgb;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class RgbTest extends TestCase
{
	public function testConstructor_ExceptionRedLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Rgb(-1, 100, 100);
	}

	public function testConstructor_ExceptionRedHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Rgb(256, 100, 100);
	}

	public function testConstructor_ExceptionGreenLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Rgb(100, -1, 100);
	}

	public function testConstructor_ExceptionGreenHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Rgb(100, 256, 100);
	}

	public function testConstructor_ExceptionBlueLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Rgb(100, 100, -1);
	}

	public function testConstructor_ExceptionBlueHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Rgb(100, 100, 256);
	}

	public function testConvertToHex(): void
	{
		$expected = new Hex('000000');
		$rgb = new Rgb(0, 0, 0);
		$hex = $rgb->toHex();
		assertEquals($expected, $hex);

		$expected = new Hex('ffffff');
		$rgb = new Rgb(255, 255, 255);
		$hex = $rgb->toHex();
		assertEquals($expected, $hex);

		$expected = new Hex('#800');
		$rgb = new Rgb(136, 0, 0);
		$hex = $rgb->toHex();
		assertEquals($expected, $hex);

		$expected = new Hex('2a445d');
		$rgb = new Rgb(42, 68, 93);
		$hex = $rgb->toHex();
		assertEquals($expected, $hex);

		$expected = new Hex('b49359');
		$rgb = new Rgb(180, 147, 89);
		$hex = $rgb->toHex();
		assertEquals($expected, $hex);
	}

	public function testConvertToHsl(): void
	{
		$expected = new Hsl(0, 0.0, 0.0);
		$rgb = new Rgb(0, 0, 0);
		$hsl = $rgb->toHsl();
		assertEquals($expected, $hsl);

		$expected = new Hsl(0, 0.0, 1.0);
		$rgb = new Rgb(255, 255, 255);
		$hsl = $rgb->toHsl();
		assertEquals($expected, $hsl);

		$expected = new Hsl(0, 1.00, 0.26667);
		$rgb = new Rgb(136, 0, 0);
		$hsl = $rgb->toHsl();
		assertEquals($expected, $hsl);

		$expected = new Hsl(209, 0.37778, 0.26471);
		$rgb = new Rgb(42, 68, 93);
		$hsl = $rgb->toHsl();
		assertEquals($expected, $hsl);

		$expected = new Hsl(38, 0.37759, 0.52745);
		$rgb = new Rgb(180, 147, 89);
		$hsl = $rgb->toHsl();
		assertEquals($expected, $hsl);
	}

	public function testConvertToHsv(): void
	{
		$expected = new Hsv(0, 0.0, 0.0);
		$rgb = new Rgb(0, 0, 0);
		$hsv = $rgb->toHsv();
		assertEquals($expected, $hsv);

		$expected = new Hsv(0, 0.0, 1.0);
		$rgb = new Rgb(255, 255, 255);
		$hsv = $rgb->toHsv();
		assertEquals($expected, $hsv);

		$expected = new Hsv(0, 1.00, 0.53333);
		$rgb = new Rgb(136, 0, 0);
		$hsv = $rgb->toHsv();
		assertEquals($expected, $hsv);

		$expected = new Hsv(209, 0.54839, 0.36471);
		$rgb = new Rgb(42, 68, 93);
		$hsv = $rgb->toHsv();
		assertEquals($expected, $hsv);

		$expected = new Hsv(38, 0.50556, 0.70588);
		$rgb = new Rgb(180, 147, 89);
		$hsv = $rgb->toHsv();
		assertEquals($expected, $hsv);
	}

	public function testGetLuminance(): void
	{
		$expected = 0;
		$rgb = new Rgb(0, 0, 0);
		$luminance = $rgb->getLuminance();
		assertEquals($expected, $luminance);

		$expected = 1;
		$rgb = new Rgb(255, 255, 255);
		$luminance = $rgb->getLuminance();
		assertEquals($expected, $luminance);

		$expected = 0.05234;
		$rgb = new Rgb(136, 0, 0);
		$luminance = $rgb->getLuminance();
		assertEquals($expected, $luminance);

		$expected = 0.05417;
		$rgb = new Rgb(42, 68, 93);
		$luminance = $rgb->getLuminance();
		assertEquals($expected, $luminance);

		$expected = 0.31292;
		$rgb = new Rgb(180, 147, 89);
		$luminance = $rgb->getLuminance();
		assertEquals($expected, $luminance);
	}
}

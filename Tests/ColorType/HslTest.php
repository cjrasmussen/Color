<?php

namespace ColorType;

use cjrasmussen\Color\ColorType\Hsl;
use cjrasmussen\Color\ColorType\Rgb;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class HslTest extends TestCase
{
	public function testConstructor(): void
	{
		$expected = new Hsl(100, 0.26667, 0.5);
		$actual = new Hsl(100, 0.26666666, 0.5);
		$this->assertEquals($expected, $actual);

		$expected = new Hsl(100, 0.5, 0.33333);
		$actual = new Hsl(100, 0.5, 0.333333333);
		$this->assertEquals($expected, $actual);
	}

	public function testConstructor_ExceptionHueLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsl(-1, 0.5, 0.5);
	}

	public function testConstructor_ExceptionHueHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsl(375, 0.5, 0.5);
	}

	public function testConstructor_ExceptionSaturationLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsl(100, -1, 0.5);
	}

	public function testConstructor_ExceptionSaturationHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsl(100, 2, 0.5);
	}

	public function testConstructor_ExceptionLightnessLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsl(100, 0.5, -1);
	}

	public function testConstructor_ExceptionLightnessHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsl(100, 0.5, 2);
	}

	public function testConvertToRgb(): void
	{
		$expected = new Rgb(0, 0, 0);
		$hsl = new Hsl(0, 0.0, 0.0);
		$rgb = $hsl->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(255, 255, 255);
		$hsl = new Hsl(0, 0.0, 1.0);
		$rgb = $hsl->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(136, 0, 0);
		$hsl = new Hsl(0, 1.0, 0.267);
		$rgb = $hsl->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(42, 68, 93);
		$hsl = new Hsl(209, 0.378, 0.265);
		$rgb = $hsl->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(180, 147, 89);
		$hsl = new Hsl(38, 0.378, 0.527);
		$rgb = $hsl->toRgb();
		assertEquals($expected, $rgb);
	}
}

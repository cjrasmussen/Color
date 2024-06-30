<?php

namespace ColorType;

use cjrasmussen\Color\ColorType\Hsv;
use cjrasmussen\Color\ColorType\Rgb;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class HsvTest extends TestCase
{
	public function testConstructor(): void
	{
		$expected = new Hsv(100, 0.26667, 0.5);
		$actual = new Hsv(100, 0.26666666, 0.5);
		$this->assertEquals($expected, $actual);

		$expected = new Hsv(100, 0.5, 0.33333);
		$actual = new Hsv(100, 0.5, 0.333333333);
		$this->assertEquals($expected, $actual);
	}

	public function testConstructor_ExceptionHueLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsv(-1, 0.5, 0.5);
	}

	public function testConstructor_ExceptionHueHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsv(375, 0.5, 0.5);
	}

	public function testConstructor_ExceptionSaturationLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsv(100, -1, 0.5);
	}

	public function testConstructor_ExceptionSaturationHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsv(100, 2, 0.5);
	}

	public function testConstructor_ExceptionValueLow(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsv(100, 0.5, -1);
	}

	public function testConstructor_ExceptionValueHigh(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hsv(100, 0.5, 2);
	}

	public function testConvertToRgb(): void
	{
		$expected = new Rgb(0, 0, 0);
		$hsv = new Hsv(0, 0.0, 0.0);
		$rgb = $hsv->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(255, 255, 255);
		$hsv = new Hsv(0, 0.0, 1.0);
		$rgb = $hsv->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(136, 0, 0);
		$hsv = new Hsv(0, 1.000, 0.533);
		$rgb = $hsv->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(42, 68, 93);
		$hsv = new Hsv(209, 0.548, 0.365);
		$rgb = $hsv->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(180, 147, 89);
		$hsv = new Hsv(38, 0.506, 0.706);
		$rgb = $hsv->toRgb();
		assertEquals($expected, $rgb);
	}
}

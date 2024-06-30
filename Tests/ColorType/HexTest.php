<?php

namespace ColorType;

use cjrasmussen\Color\ColorType\Hex;
use cjrasmussen\Color\ColorType\Rgb;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class HexTest extends TestCase
{
	public function testConstructor(): void
	{
		$hex = new Hex(333);
		assertEquals('333333', $hex->hexString);

		$hex = new Hex(333333);
		assertEquals('333333', $hex->hexString);

		$hex = new Hex('abc');
		assertEquals('aabbcc', $hex->hexString);

		$hex = new Hex('aabbcc');
		assertEquals('aabbcc', $hex->hexString);

		$hex = new Hex('#800');
		assertEquals('880000', $hex->hexString);
	}

	public function testConstructor_ExceptionLongInt(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hex(123456789);
	}

	public function testConstructor_ExceptionShortInt(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hex(12);
	}

	public function testConstructor_ExceptionLongString(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hex('edf123abc');
	}

	public function testConstructor_ExceptionShortString(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hex('edf1');
	}

	public function testConstructor_ExceptionNotHex(): void
	{
		$this->expectException(InvalidArgumentException::class);
		new Hex('taco24');
	}

	public function testToString(): void
	{
		$expected = '000000';
		$hex = new Hex('#000');
		$this->assertEquals($expected, (string)$hex);

		$expected = 'ffffff';
		$hex = new Hex('fff');
		$this->assertEquals($expected, (string)$hex);

		$expected = '112233';
		$hex = new Hex(123);
		$this->assertEquals($expected, (string)$hex);
	}

	public function testConvertToRgb(): void
	{
		$expected = new Rgb(0, 0, 0);
		$hex = new Hex('000000');
		$rgb = $hex->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(255, 255, 255);
		$hex = new Hex('ffffff');
		$rgb = $hex->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(136, 0, 0);
		$hex = new Hex('#800');
		$rgb = $hex->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(42, 68, 93);
		$hex = new Hex('2a445d');
		$rgb = $hex->toRgb();
		assertEquals($expected, $rgb);

		$expected = new Rgb(180, 147, 89);
		$hex = new Hex('b49359');
		$rgb = $hex->toRgb();
		assertEquals($expected, $rgb);
	}
}

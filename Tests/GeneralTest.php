<?php

use cjrasmussen\Color\ColorType\Rgb;
use cjrasmussen\Color\General;
use PHPUnit\Framework\TestCase;

class GeneralTest extends TestCase
{
	private Rgb $black;
	private Rgb $white;
	private Rgb $darkGrey;
	private Rgb $lightGrey;
	private Rgb $grey;

	public function setUp(): void
	{
		$this->black = new Rgb(0, 0, 0);
		$this->white = new Rgb(255, 255, 255);
		$this->darkGrey = new Rgb(50, 50, 50);
		$this->lightGrey = new Rgb(200, 200, 200);
		$this->grey = new Rgb(128, 128, 128);
	}

	public function testDoColorsContrast(): void
	{
		$result = General::doColorsContrast($this->black, $this->white);
		$this->assertTrue($result);

		$result = General::doColorsContrast($this->black, $this->lightGrey);
		$this->assertTrue($result);

		$result = General::doColorsContrast($this->white, $this->darkGrey);
		$this->assertTrue($result);

		$result = General::doColorsContrast($this->black, $this->darkGrey);
		$this->assertFalse($result);

		$result = General::doColorsContrast($this->white, $this->lightGrey);
		$this->assertFalse($result);

		$result = General::doColorsContrast($this->black, $this->grey);
		$this->assertTrue($result);

		$result = General::doColorsContrast($this->white, $this->grey);
		$this->assertFalse($result);

		$result = General::doColorsContrast($this->white, $this->grey, 3);
		$this->assertTrue($result);
	}

	public function testCalculateColorContrast(): void
	{
		$expected = 21;
		$result = General::calculateColorContrast($this->black, $this->white);
		$this->assertEquals($expected, $result);

		$expected = 12.5516;
		$result = General::calculateColorContrast($this->black, $this->lightGrey);
		$this->assertEquals($expected, $result);

		$expected = 12.820512820512821;
		$result = General::calculateColorContrast($this->white, $this->darkGrey);
		$this->assertEquals($expected, $result);

		$expected = 1.638;
		$result = General::calculateColorContrast($this->black, $this->darkGrey);
		$this->assertEquals($expected, $result);

		$expected = 1.6730934701551994;
		$result = General::calculateColorContrast($this->white, $this->lightGrey);
		$this->assertEquals($expected, $result);

		$expected = 5.3172;
		$result = General::calculateColorContrast($this->black, $this->grey);
		$this->assertEquals($expected, $result);

		$expected = 3.9494470774091632;
		$result = General::calculateColorContrast($this->white, $this->grey);
		$this->assertEquals($expected, $result);
	}
}

<?php namespace Tests\Database\Definition\Table\Columns\Numeric;

use Tests\Database\TestCase;

class NumericDataTypeTest extends TestCase
{
	protected NumericDataTypeMock $column;

	protected function setUp() : void
	{
		$this->column = new NumericDataTypeMock(static::$database);
	}

	public function testAutoIncrement()
	{
		$this->assertEquals(
			' mock AUTO_INCREMENT NOT NULL',
			$this->column->autoIncrement()->sql()
		);
	}

	public function testSigned()
	{
		$this->assertEquals(
			' mock signed NOT NULL',
			$this->column->signed()->sql()
		);
	}

	public function testUnsigned()
	{
		$this->assertEquals(
			' mock unsigned NOT NULL',
			$this->column->unsigned()->sql()
		);
	}

	public function testZerofill()
	{
		$this->assertEquals(
			' mock zerofill NOT NULL',
			$this->column->zerofill()->sql()
		);
	}

	public function testFull()
	{
		$this->assertEquals(
			' mock unsigned zerofill AUTO_INCREMENT NOT NULL',
			$this->column->unsigned()->zerofill()->autoIncrement()->sql()
		);
	}
}

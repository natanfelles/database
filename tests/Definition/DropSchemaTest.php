<?php namespace Tests\Database\Definition;

use Framework\Database\Definition\DropSchema;
use Tests\Database\TestCase;

class DropSchemaTest extends TestCase
{
	protected DropSchema $dropSchema;

	protected function setUp() : void
	{
		$this->dropSchema = new DropSchema(static::$database);
	}

	public function testEmptySchema()
	{
		$this->expectException(\LogicException::class);
		$this->expectExceptionMessage('SCHEMA name must be set');
		$this->dropSchema->sql();
	}

	public function testSchema()
	{
		$this->assertEquals(
			"DROP SCHEMA `app`\n",
			$this->dropSchema->schema('app')->sql()
		);
	}

	public function testIfExists()
	{
		$this->assertEquals(
			"DROP SCHEMA IF EXISTS `app`\n",
			$this->dropSchema->ifExists()->schema('app')->sql()
		);
	}
}

<?php namespace Tests\Database\Definition\Table\Indexes\Keys;

use Framework\Database\Definition\Table\Indexes\Keys\ForeignKey;
use Tests\Database\TestCase;

class ForeignKeyTest extends TestCase
{
	protected ForeignKey $index;

	protected function setUp() : void
	{
		$this->index = new ForeignKey(static::$database, null, 'user_id');
	}

	public function testEmptyReferences()
	{
		$this->expectException(\LogicException::class);
		$this->expectExceptionMessage('REFERENCES clause was not set');
		$this->index->sql();
	}

	public function testReferences()
	{
		$this->index->references('users', 'id');
		$this->assertEquals(
			' FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)',
			$this->index->sql()
		);
	}

	public function testOnDelete()
	{
		$this->index->references('users', 'id')->onDelete('restrict');
		$this->assertEquals(
			' FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT',
			$this->index->sql()
		);
	}

	public function testOnUpdate()
	{
		$this->index->references('users', 'id')->onUpdate('cascade');
		$this->assertEquals(
			' FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE',
			$this->index->sql()
		);
	}

	public function testInvalidReferenceOption()
	{
		$this->index->references('users', 'id')->onUpdate('foo');
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Invalid reference option: foo');
		$this->index->sql();
	}
}

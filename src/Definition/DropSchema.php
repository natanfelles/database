<?php namespace Framework\Database\Definition;

use Framework\Database\Statement;
use LogicException;

/**
 * Class DropSchema.
 *
 * @see https://mariadb.com/kb/en/library/drop-database/
 */
class DropSchema extends Statement
{
	public function ifExists()
	{
		$this->sql['if_exists'] = true;
		return $this;
	}

	protected function renderIfExists() : ?string
	{
		if ( ! isset($this->sql['if_exists'])) {
			return null;
		}
		return ' IF EXISTS';
	}

	public function schema(string $schema_name)
	{
		$this->sql['schema'] = $schema_name;
		return $this;
	}

	protected function renderSchema() : string
	{
		if (isset($this->sql['schema'])) {
			return ' ' . $this->database->protectIdentifier($this->sql['schema']);
		}
		throw new LogicException('SCHEMA name must be set');
	}

	public function sql() : string
	{
		$sql = 'DROP SCHEMA' . $this->renderIfExists();
		$sql .= $this->renderSchema() . \PHP_EOL;
		return $sql;
	}

	/**
	 * Runs the CREATE SCHEMA statement.
	 *
	 * @return int The number of affected rows
	 */
	public function run() : int
	{
		return $this->database->exec($this->sql());
	}
}

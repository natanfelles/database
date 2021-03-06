<?php namespace Framework\Database\Definition\Table;

use Framework\Database\Database;
use Framework\Database\Definition\Table\Columns\ColumnDefinition;
use Framework\Database\Definition\Table\Indexes\IndexDefinition;

class TableDefinition extends DefinitionPart
{
	protected Database $database;
	protected array $columns = [];
	protected array $indexes = [];

	/**
	 * TableDefinition constructor.
	 *
	 * @param Database $database
	 */
	public function __construct(Database $database)
	{
		$this->database = $database;
	}

	/**
	 * Adds a column to the Table Definition list.
	 *
	 * @param string      $name        Column name
	 * @param string|null $change_name New column name. Used on ALTER TABLE CHANGE
	 *
	 * @return ColumnDefinition
	 */
	public function column(string $name, string $change_name = null) : ColumnDefinition
	{
		$definition = new ColumnDefinition($this->database);
		$this->columns[] = [
			'name' => $name,
			'change_name' => $change_name,
			'definition' => $definition,
		];
		return $definition;
	}

	/**
	 * Adds an index to the Table Definition list.
	 *
	 * @param string|null $name Index name
	 *
	 * @return IndexDefinition
	 */
	public function index(string $name = null) : IndexDefinition
	{
		$definition = new IndexDefinition($this->database, $name);
		$this->indexes[] = [
			'name' => $name,
			'definition' => $definition,
		];
		return $definition;
	}

	protected function renderColumns(string $prefix = null) : string
	{
		if ($prefix) {
			$prefix .= ' COLUMN';
		}
		$sql = [];
		foreach ($this->columns as $column) {
			$name = $this->database->protectIdentifier($column['name']);
			$change_name = $column['change_name']
				? ' ' . $this->database->protectIdentifier($column['change_name'])
				: null;
			$definition = $column['definition']->sql();
			$sql[] = " {$prefix} {$name}{$change_name}{$definition}";
		}
		return \implode(',' . \PHP_EOL, $sql);
	}

	protected function renderIndexes(string $prefix = null) : string
	{
		$sql = [];
		foreach ($this->indexes as $index) {
			$definition = $index['definition']->sql();
			$sql[] = " {$prefix}{$definition}";
		}
		return \implode(',' . \PHP_EOL, $sql);
	}

	protected function sql(string $prefix = null) : string
	{
		$sql = $this->renderColumns($prefix);
		if ($part = $this->renderIndexes($prefix)) {
			$sql .= ',' . \PHP_EOL . $part;
		}
		return $sql;
	}
}

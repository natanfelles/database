<?php namespace Framework\Database;

/**
 * Class Statement.
 */
abstract class Statement
{
	protected Database $database;
	/**
	 * SQL clauses and parts.
	 *
	 * @var mixed[]
	 */
	protected array $sql = [];

	/**
	 * Statement constructor.
	 *
	 * @param Database $database
	 */
	public function __construct(Database $database)
	{
		$this->database = $database;
	}

	public function __toString() : string
	{
		return $this->sql();
	}

	/**
	 * Resets SQL clauses and parts.
	 *
	 * @param string|null $sql A part name or null to reset all
	 *
	 * @see Statement::$sql
	 *
	 * @return $this
	 */
	public function reset(string $sql = null)
	{
		if ($sql === null) {
			unset($this->sql);
			return $this;
		}
		unset($this->sql[$sql]);
		return $this;
	}

	/**
	 * Renders the SQL statement.
	 *
	 * @return string
	 */
	abstract public function sql() : string;

	/**
	 * Runs the SQL statement.
	 *
	 * @return mixed
	 */
	abstract public function run();
}

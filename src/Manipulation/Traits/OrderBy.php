<?php namespace Framework\Database\Manipulation\Traits;

use Closure;

/**
 * Trait OrderBy.
 *
 * @see https://mariadb.com/kb/en/library/order-by/
 */
trait OrderBy
{
	/**
	 * Appends columns to the ORDER BY clause.
	 *
	 * @param Closure|string $column
	 * @param mixed          $columns Each column must be of type: string or \Closure
	 *
	 * @return $this
	 */
	public function orderBy($column, ...$columns)
	{
		return $this->addOrderBy($column, $columns, null);
	}

	/**
	 * Appends columns with the ASC direction to the ORDER BY clause.
	 *
	 * @param Closure|string $column
	 * @param mixed          $columns Each column must be of type: string or \Closure
	 *
	 * @return $this
	 */
	public function orderByAsc($column, ...$columns)
	{
		return $this->addOrderBy($column, $columns, 'ASC');
	}

	/**
	 * Appends columns with the DESC direction to the ORDER BY clause.
	 *
	 * @param Closure|string $column
	 * @param mixed          $columns Each column must be of type: string or \Closure
	 *
	 * @return $this
	 */
	public function orderByDesc($column, ...$columns)
	{
		return $this->addOrderBy($column, $columns, 'DESC');
	}

	private function addOrderBy($column, array $columns, ?string $direction)
	{
		$columns = $this->mergeExpressions($column, $columns);
		foreach ($columns as $column) {
			$this->sql['order_by'][] = [
				'column' => $column,
				'direction' => $direction,
			];
		}
		return $this;
	}

	protected function renderOrderBy() : ?string
	{
		if ( ! isset($this->sql['order_by'])) {
			return null;
		}
		$expressions = [];
		foreach ($this->sql['order_by'] as $part) {
			$expression = $this->renderIdentifier($part['column']);
			if ($part['direction']) {
				$expression .= " {$part['direction']}";
			}
			$expressions[] = $expression;
		}
		$expressions = \implode(', ', $expressions);
		return " ORDER BY {$expressions}";
	}
}

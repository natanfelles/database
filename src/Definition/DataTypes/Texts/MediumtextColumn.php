<?php namespace Framework\Database\Definition\DataTypes\Texts;

/**
 * Class MediumtextColumn.
 *
 * @see https://mariadb.com/kb/en/library/mediumtext/
 */
class MediumtextColumn extends TextDataType
{
	protected $type = 'MEDIUMTEXT';
	protected $minLength = 0;
	protected $maxLength = 65535;
}
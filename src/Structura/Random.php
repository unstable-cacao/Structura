<?php
namespace Structura;


use Structura\Exceptions\StructuraException;


class Random
{
	public const ALPHA_NUMERIC_ANY_CASE = 'abcdefghijklmnopqrstvuwxyzABCDEFGHIJKLMNOPQRSTVUWXYZ01234567890';
	public const ALPHA_NUMERIC_LOWERCASE = 'abcdefghijklmnopqrstvuwxyz01234567890';
	
	
	public static function string(int $length, string $from = self::ALPHA_NUMERIC_ANY_CASE): string
	{
		$result = '';
		$setSize = strlen($from);
		
		if ($setSize == 0 || $length <= 0)
			throw new StructuraException('Values set is empty');
		
		for ($i = 0; $i < $length; $i++)
		{
			$result .= $from[mt_rand(0, $setSize - 1)];
		}
		
		return $result;
	}
}
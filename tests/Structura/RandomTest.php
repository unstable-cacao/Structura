<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class RandomTest extends TestCase
{
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_string_EmptySetPassed_ExceptionThrown(): void
	{
		Random::string(123, '');
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_string_InvalidLengthPassed_ExceptionThrown(): void
	{
		Random::string(0, 'abc');
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_string_NegativeLengthPassed_ExceptionThrown(): void
	{
		Random::string(-23, 'abc');
	}
	
	
	public function test_string_OnlyOneCharacterInSet_RandomStringGenerated(): void
	{
		self::assertEquals('aaaaa', Random::string(5, 'a'));
	}
	
	public function test_string_StringOfCorrectLengthGenerated(): void
	{
		for ($i = 0; $i < 10; $i++)
		{
			$res = Random::string(5 + $i, 'abcdef');
			self::assertEquals(5 + $i, strlen($res));
		}
	}
	
	public function test_string_DifferentCharactersUsed_AllCharactersAppearInTestSet(): void
	{
		$count = 10000;
		$charsCount = 5;
		$limit = ($count / $charsCount) * 0.9;
		
		
		$res = Random::string($count, 'abcde');
		
		
		$as = substr_count($res, 'a');
		$bs = substr_count($res, 'b');
		$cs = substr_count($res, 'c');
		$ds = substr_count($res, 'd');
		$es = substr_count($res, 'e');
		
		self::assertTrue($as > $limit);
		self::assertTrue($bs > $limit);
		self::assertTrue($cs > $limit);
		self::assertTrue($ds > $limit);
		self::assertTrue($es > $limit);
	}
}
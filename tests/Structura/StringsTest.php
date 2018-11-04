<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class StringsTest extends TestCase
{
	public function test_isStartsWith_NotStartsWith_ReturnFalse()
	{
		self::assertFalse(Strings::isStartsWith('abcdef', 'abd'));
	}
	
	public function test_isStartsWith_StartsWith_ReturnTrue()
	{
		self::assertTrue(Strings::isStartsWith('abcdef', 'abc'));
	}
	
	public function test_isStartsWith_StartParamEmpty_ReturnTrue()
	{
		self::assertTrue(Strings::isStartsWith('abcdef', ''));
	}
	
	public function test_isEndsWith_NotEndsWith_ReturnFalse()
	{
		self::assertFalse(Strings::isEndsWith('abcdef', 'dff'));
	}
	
	public function test_isEndsWith_EndsWith_ReturnTrue()
	{
		self::assertTrue(Strings::isEndsWith('abcdef', 'def'));
	}
	
	public function test_isEndsWith_EndParamEmpty_ReturnTrue()
	{
		self::assertTrue(Strings::isEndsWith('abcdef', ''));
	}
	
	public function test_replace_LimitNull_ReplaceAll()
	{
		self::assertEquals('as-big-as-ever', Strings::replace('as big as ever', ' ', '-'));
	}
	
	public function test_replace_NeedleEmpty_ReplaceNothing()
	{
		self::assertEquals('as big as ever', Strings::replace('as big as ever', '', '-', 5));
	}
	
	public function test_replace_WithEmpty_RemoveNeedle()
	{
		self::assertEquals('asbigasever', Strings::replace('as big as ever', ' ', '', 5));
	}
	
	public function test_replace_SubjectEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::replace('', ' ', '-', 5));
	}
	
	public function test_replace_LimitBiggerThanCount_ReplaceAll()
	{
		self::assertEquals('as-big-as-ever', Strings::replace('as big as ever', ' ', '-', 5));
	}
	
	public function test_replace_LimitSmallerThanCount_ReplaceByLimit()
	{
		self::assertEquals('as-big-as ever', Strings::replace('as big as ever', ' ', '-', 2));
	}
	
	public function test_endWith_SourceEmpty_ReturnEndString()
	{
		self::assertEquals('ing', Strings::endWith('', 'ing'));
	}
	
	public function test_endWith_EndIsEmpty_ReturnSource()
	{
		self::assertEquals('testing', Strings::endWith('testing', ''));
	}
	
	public function test_endWith_EndAndSourceEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::endWith('', ''));
	}
	
	public function test_endWith_EndsWith_ReturnSource()
	{
		self::assertEquals('testing', Strings::endWith('testing', 'ing'));
	}
	
	public function test_endWith_NotEndsWith_ReturnSourceAndEnd()
	{
		self::assertEquals('testinggg', Strings::endWith('testing', 'gg'));
	}
	
	public function test_startWith_SourceEmpty_ReturnStartString()
	{
		self::assertEquals('test', Strings::startWith('', 'test'));
	}
	
	public function test_startWith_StartIsEmpty_ReturnSource()
	{
		self::assertEquals('ing', Strings::startWith('ing', ''));
	}
	
	public function test_startWith_StartAndSourceEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::startWith('', ''));
	}
	
	public function test_startWith_StartsWith_ReturnSource()
	{
		self::assertEquals('testing', Strings::startWith('testing', 'test'));
	}
	
	public function test_startWith_NotStartsWith_ReturnStartAndSource()
	{
		self::assertEquals('tttesting', Strings::startWith('testing', 'tt'));
	}
}
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
	
	public function test_isStartsWith_SubjectShorterThanTarget_ReturnFalse()
	{
		self::assertFalse(Strings::isStartsWith('abc', 'abcdef'));
	}
	
	public function test_isStartsWith_WorksWithNonUtf8()
	{
		self::assertFalse(Strings::isStartsWith('abc', '👺'));
		self::assertTrue(Strings::isStartsWith('👺abc', '👺'));
	}
	
	public function test_isEndsWith_NotEndsWith_ReturnFalse()
	{
		self::assertFalse(Strings::isEndsWith('abcdef', 'dff'));
	}
	
	public function test_isEndsWith_EndsWith_ReturnTrue()
	{
		self::assertTrue(Strings::isEndsWith('abcdef', 'def'));
	}
	
	public function test_isEndsWith_SubjectShorterThanTarget_ReturnFalse()
	{
		self::assertFalse(Strings::isEndsWith('def', 'abcdef'));
	}
	
	public function test_isEndsWith_EndParamEmpty_ReturnTrue()
	{
		self::assertTrue(Strings::isEndsWith('abcdef', ''));
	}
	
	public function test_isEndsWith_WorksWithNonUtf8()
	{
		self::assertFalse(Strings::isEndsWith('abcdef', '💩'));
		self::assertTrue(Strings::isEndsWith('abcdef💩', '💩'));
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
	
	public function test_replace_WorksWithNonUtf8()
	{
		self::assertEquals('as-big-as ever', Strings::replace('as💀big💀as ever', '💀', '-', 2));
		self::assertEquals('as-big-a💀 ever', Strings::replace('as big a💀 ever', ' ', '-', 2));
	}
	
	public function test_append_SourceEmpty_ReturnEndString()
	{
		self::assertEquals('ing', Strings::append('', 'ing'));
	}
	
	public function test_append_EndIsEmpty_ReturnSource()
	{
		self::assertEquals('testing', Strings::append('testing', ''));
	}
	
	public function test_append_EndAndSourceEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::append('', ''));
	}
	
	public function test_append_EndsWith_ReturnSource()
	{
		self::assertEquals('testing', Strings::append('testing', 'ing'));
	}
	
	public function test_append_NotEndsWith_ReturnSourceAndEnd()
	{
		self::assertEquals('testinggg', Strings::append('testing', 'gg'));
	}
	
	public function test_append_WorksWithNonUtf8()
	{
		self::assertEquals('testin👻', Strings::append('testin👻', '👻'));
		self::assertEquals('testing👻', Strings::append('testing', '👻'));
	}
	
	public function test_prepend_SourceEmpty_ReturnStartString()
	{
		self::assertEquals('test', Strings::prepend('', 'test'));
	}
	
	public function test_prepend_StartIsEmpty_ReturnSource()
	{
		self::assertEquals('ing', Strings::prepend('ing', ''));
	}
	
	public function test_prepend_StartAndSourceEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::prepend('', ''));
	}
	
	public function test_prepend_StartsWith_ReturnSource()
	{
		self::assertEquals('testing', Strings::prepend('testing', 'test'));
	}
	
	public function test_prepend_NotStartsWith_ReturnStartAndSource()
	{
		self::assertEquals('tttesting', Strings::prepend('testing', 'tt'));
	}
	
	public function test_prepend_WorksWithNonUtf8()
	{
		self::assertEquals('😳testing', Strings::prepend('😳testing', '😳'));
		self::assertEquals('😳testing', Strings::prepend('testing', '😳'));
	}
	
	public function test_trimStart_SourceEmpty_ReturnEmtpy()
	{
		self::assertEquals('', Strings::trimStart('', 'test'));
	}
	
	public function test_trimStart_StartIsEmpty_ReturnSource()
	{
		self::assertEquals('ing', Strings::trimStart('ing', ''));
	}
	
	public function test_trimStart_StartAndSourceEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::trimStart('', ''));
	}
	
	public function test_trimStart_StartsWith_RemoveStart()
	{
		self::assertEquals('ing', Strings::trimStart('testing', 'test'));
	}
	
	public function test_trimStart_NotStartsWith_ReturnSource()
	{
		self::assertEquals('testing', Strings::trimStart('testing', 'tt'));
	}
	
	public function test_trimStart_WorksWithNonUtf8()
	{
		self::assertEquals('testing', Strings::trimStart('😱testing', '😱'));
		self::assertEquals('testing', Strings::trimStart('testing', '😱'));
	}
	
	public function test_trimEnd_SourceEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::trimEnd('', 'ing'));
	}
	
	public function test_trimEnd_EndIsEmpty_ReturnSource()
	{
		self::assertEquals('testing', Strings::trimEnd('testing', ''));
	}
	
	public function test_trimEnd_EndAndSourceEmpty_ReturnEmpty()
	{
		self::assertEquals('', Strings::trimEnd('', ''));
	}
	
	public function test_trimEnd_EndsWith_RemoveEnd()
	{
		self::assertEquals('test', Strings::trimEnd('testing', 'ing'));
	}
	
	public function test_trimEnd_NotEndsWith_ReturnSource()
	{
		self::assertEquals('testing', Strings::trimEnd('testing', 'gg'));
	}
	
	public function test_trimEnd_WorksWithNonUtf8()
	{
		self::assertEquals('testing', Strings::trimEnd('testing😒', '😒'));
		self::assertEquals('testing', Strings::trimEnd('testing', '😒'));
	}
	
	public function test_contains_HaystackEmpty_ReturnFalse()
	{
		self::assertFalse(Strings::contains('', 'test'));
	}
	
	public function test_contains_NeedleEmpty_ReturnTrue()
	{
		self::assertTrue(Strings::contains('test', ''));
	}
	
	public function test_contains_Contains_ReturnTrue()
	{
		self::assertTrue(Strings::contains('test', 'te'));
	}
	
	public function test_contains_NotContains_ReturnFalse()
	{
		self::assertFalse(Strings::contains('test', 'tet'));
	}
	
	public function test_contains_WorksWithNonUtf8()
	{
		self::assertTrue(Strings::contains('testing😒', '😒'));
		self::assertFalse(Strings::contains('test😒', '😱'));
	}
	
	public function test_cut_SourceEmpty_DoNothing()
	{
		self::assertEquals('', Strings::cut('', 0));
	}
	
	public function test_cut_IndexParameterNotValid_ExceptionThrown()
	{
		$this->expectException(\Structura\Exceptions\StructuraException::class);
		
		Strings::cut('test', 'notInt');
	}
	
	public function test_cut_IndexParameterArrayNotValid_ExceptionThrown()
	{
		$this->expectException(\Structura\Exceptions\StructuraException::class);
		
		Strings::cut('test', [5]);
	}
	
	public function test_cut_LengthNotValid_DoNothing()
	{
		self::assertEquals('test', Strings::cut('test', [1, 'notInt']));
	}
	
	public function test_cut_IndexOutOfRange_DoNothing()
	{
		self::assertEquals('test', Strings::cut('test', 13));
	}
	
	public function test_cut_LengthMoreThanLength_ReturnWithoutEnd()
	{
		self::assertEquals('t', Strings::cut('test', 1, 15));
	}
	
	public function test_cut_CutCorrectly()
	{
		self::assertEquals('helloworld', Strings::cut('hello world', 5));
		self::assertEquals('helloorld', Strings::cut('hello world', 5, 2));
		self::assertEquals('helloorld', Strings::cut('hello world', [5, 2]));
		self::assertEquals('ello world', Strings::cut('hello world', 0, 0));
	}
	
	public function test_cut_WorksWithNonUtf8()
	{
		self::assertEquals('helloworld', Strings::cut('hello😒world', 5));
		self::assertEquals('😒helloworld', Strings::cut('😒hello world', 6));
	}
}
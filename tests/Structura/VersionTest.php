<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class VersionTest extends TestCase
{
	public function test_sanity()
	{
		$v = new Version();
		
		$v->setBuild(123);
		$v->setFlag('ma-flag');
		$v->setMajor(5);
		$v->setMinor(8);
		$v->setPatch(9);
		
		self::assertEquals(123, $v->getBuild());
		self::assertEquals('ma-flag', $v->getFlag());
		self::assertEquals(5, $v->getMajor());
		self::assertEquals(8, $v->getMinor());
		self::assertEquals(9, $v->getPatch());
		
		
		$v->setFlag(VersionType::BETA);
		self::assertEquals(VersionType::BETA, $v->getFlag());
	}
	
	
	public function test_constructor_PassAllValues()
	{
		$v = new Version('1.2.3.4');
		
		self::assertEquals(1, $v->getMajor());
		self::assertEquals(2, $v->getMinor());
		self::assertEquals(3, $v->getBuild());
		self::assertEquals(4, $v->getPatch());
		self::assertEquals('', $v->getFlag());
	}
	
	public function test_constructor_PassAnotherVersion_DataCopied()
	{
		$original = new Version('1.2.3.4');
		$original->setFlag('abc');
		
		
		$v = new Version($original);
		
		
		self::assertEquals($v->toArray(), $original->toArray());
	}
	
	public function test_constructor_PassAnotherVersion_OriginalVersionNotReferenced()
	{
		$original = new Version('1.2.3.4');
		$original->setFlag('abc');
		$data = $original->toArray();
		
		
		$v = new Version($original);
		$v->setMajor(2);
		$v->setFlag('def');
		
		
		self::assertEquals($data, $original->toArray());
		self::assertNotEquals($data, $v->toArray());
	}
	
	public function test_constructor_PassPartialValues()
	{
		$v = new Version('1.2');
		
		self::assertEquals(1, $v->getMajor());
		self::assertEquals(2, $v->getMinor());
		self::assertEquals(0, $v->getBuild());
		self::assertEquals(0, $v->getPatch());
		self::assertEquals('', $v->getFlag());
	}
	
	public function test_constructor_PassNothing()
	{
		$v = new Version();
		
		self::assertEquals(0, $v->getMajor());
		self::assertEquals(0, $v->getMinor());
		self::assertEquals(0, $v->getBuild());
		self::assertEquals(0, $v->getPatch());
		self::assertEquals('', $v->getFlag());
	}
	
	
	public function test_isSame_SameVersionsPassed_ReturnTrue()
	{
		$v1 = new Version('1.2.3.4');
		$v2 = new Version('1.2.3.4');
		
		self::assertTrue($v1->isSame($v2));
		self::assertTrue($v2->isSame($v1));
	}
	
	public function test_isSame_DifferentVersionsPassed_ReturnFalse()
	{
		self::assertFalse((new Version('1.2.3.4'))->isSame(new Version('1.2.3.10')));
		self::assertFalse((new Version('1.2.3.4'))->isSame(new Version('1.2.10.4')));
		self::assertFalse((new Version('1.2.3.4'))->isSame(new Version('1.10.3.4')));
		self::assertFalse((new Version('1.2.3.4'))->isSame(new Version('10.2.3.4')));
	}
	
	public function test_isSame_FlagIgnored()
	{
		$v1 = new Version('1.2.3.4');
		$v2 = new Version('1.2.3.4');
		
		$v1->setFlag('hello');
		
		self::assertTrue($v1->isSame($v2));
		self::assertTrue($v2->isSame($v1));
		
		$v2->setFlag('world');
		
		self::assertTrue($v1->isSame($v2));
		self::assertTrue($v2->isSame($v1));
	}
	
	
	public function test_isLower()
	{
		self::assertFalse((new Version('1.2.3.4'))->isLower(new Version('1.2.3.4')));
		
		self::assertTrue((new Version('1.2.3.4'))->isLower(new Version('1.2.3.10')));
		self::assertTrue((new Version('1.2.3.4'))->isLower(new Version('1.2.10.4')));
		self::assertTrue((new Version('1.2.3.4'))->isLower(new Version('1.10.3.4')));
		self::assertTrue((new Version('1.2.3.4'))->isLower(new Version('10.2.3.4')));
		
		self::assertFalse((new Version('1.2.3.10'))->isLower(new Version('1.2.3.4')));
		self::assertFalse((new Version('1.2.10.4'))->isLower(new Version('1.2.3.4')));
		self::assertFalse((new Version('1.10.3.4'))->isLower(new Version('1.2.3.4')));
		self::assertFalse((new Version('10.2.3.4'))->isLower(new Version('1.2.3.4')));
	}
	
	public function test_isLower_MoreImportantNumberConsideredBeforeOthers()
	{
		self::assertFalse((new Version('1.20.3.4'))->isLower(new Version('1.2.30.4')));
		self::assertTrue((new Version('1.2.30.4'))->isLower(new Version('1.20.3.4')));
	}
	
	public function test_isLower_FlagIgnored()
	{
		$v1 = new Version('1.2.3.4');
		$v2 = new Version('1.2.3.4');
		$v3 = new Version('1.2.3.5');
		$v4 = new Version('1.2.3.5');
		
		$v1->setFlag('hello');
		$v2->setFlag('world');
		$v4->setFlag('abc');
		
		self::assertFalse($v1->isLower($v2));
		self::assertFalse($v2->isLower($v1));
		self::assertFalse($v3->isLower($v2));
		self::assertTrue($v2->isLower($v3));
		
		self::assertFalse($v4->isLower($v3));
		self::assertFalse($v3->isLower($v4));
	}
	
	
	public function test_isHigher()
	{
		self::assertFalse((new Version('1.2.3.4'))->isHigher(new Version('1.2.3.4')));
		
		self::assertFalse((new Version('1.2.3.4'))->isHigher(new Version('1.2.3.10')));
		self::assertFalse((new Version('1.2.3.4'))->isHigher(new Version('1.2.10.4')));
		self::assertFalse((new Version('1.2.3.4'))->isHigher(new Version('1.10.3.4')));
		self::assertFalse((new Version('1.2.3.4'))->isHigher(new Version('10.2.3.4')));
		
		self::assertTrue((new Version('1.2.3.10'))->isHigher(new Version('1.2.3.4')));
		self::assertTrue((new Version('1.2.10.4'))->isHigher(new Version('1.2.3.4')));
		self::assertTrue((new Version('1.10.3.4'))->isHigher(new Version('1.2.3.4')));
		self::assertTrue((new Version('10.2.3.4'))->isHigher(new Version('1.2.3.4')));
	}
	
	public function test_isHigher_MoreImportantNumberConsideredBeforeOthers()
	{
		self::assertTrue((new Version('1.20.3.4'))->isHigher(new Version('1.2.30.4')));
		self::assertFalse((new Version('1.2.30.4'))->isHigher(new Version('1.20.3.4')));
	}
	
	public function test_isHigher_FlagIgnored()
	{
		$v1 = new Version('1.2.3.4');
		$v2 = new Version('1.2.3.4');
		$v3 = new Version('1.2.3.5');
		$v4 = new Version('1.2.3.5');
		
		$v1->setFlag('hello');
		$v2->setFlag('world');
		$v4->setFlag('abc');
		
		self::assertFalse($v1->isHigher($v2));
		self::assertFalse($v2->isHigher($v1));
		self::assertTrue($v3->isHigher($v2));
		self::assertFalse($v2->isHigher($v3));
		
		self::assertFalse($v4->isHigher($v3));
		self::assertFalse($v3->isHigher($v4));
	}
	
	
	public function test_format_EmptyStringPassed_ReturnEmptyString()
	{
		$v1 = new Version('1.2.3.4');
		self::assertEquals('', $v1->format(''));
	}
	
	public function test_format_NoParamsPassed_DefaultFormatUsed()
	{
		$v1 = new Version('1.2.3.4');
		self::assertEquals('1.2.3.4', $v1->format());
	}
	
	public function test_format_FormatPassed_FormattedDataReturned()
	{
		$v1 = new Version('1.2.3.4');
		self::assertEquals('1-2.3 4', $v1->format('M-m.b p'));
	}
	
	
	public function test_toString_DataFormatted()
	{
		$v1 = new Version('1.2.3.4');
		self::assertEquals('1.2.3.4', $v1->toString());
	}
	
	
	public function test_toStringMagicMethod()
	{
		$v1 = new Version('1.2.3.4');
		self::assertEquals('1.2.3.4', (string)$v1);
	}
	

	public function test_fromString()
	{
		$v = new Version();
		
		$v->fromString('1.2.3.4');
		self::assertEquals('1.2.3.4', (string)$v);
		
		$v->fromString('1.2');
		self::assertEquals('1.2.0.0', (string)$v);
	}
	
	
	public function test_toArray()
	{
		$v = new Version();
		
		$v->fromString('1.2.3.4');
		self::assertEquals([1, 2, 3, 4], $v->toArray());
		
		$v->fromString('1.2');
		self::assertEquals([1, 2, 0, 0], $v->toArray());
	}
	
	public function test_compare()
	{
		$v1 = new Version('1.2.3.4');
		$v2 = new Version('1.2.3.4');
		$v3 = new Version('1.2.3.2');
		$v4 = new Version('1.2.2.5');
		
		$v5 = new Version('1.2.3.4');
		$v5->setFlag('abc');
		
		
		self::assertEquals(0, $v1->compare($v2));
		self::assertEquals(0, $v2->compare($v1));
		self::assertEquals(0, $v5->compare($v1));
		self::assertEquals(0, $v1->compare($v5));
		
		
		self::assertEquals(-1,	$v2->compare($v3));
		self::assertEquals(1,	$v3->compare($v2));
		
		self::assertEquals(1,	$v4->compare($v3));
		self::assertEquals(-1,	$v3->compare($v4));
	}
}
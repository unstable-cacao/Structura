<?php
namespace Structura\Table\Index;


use PHPUnit\Framework\TestCase;


class BooleanIndexTest extends TestCase
{
	public function test_ReturnSelf()
	{
		$subject = new BooleanIndex();
		
		self::assertEquals($subject, $subject->add(1, true));
		self::assertEquals($subject, $subject->addBulk([2 => true]));
		self::assertEquals($subject, $subject->remRowIDs([1 => true, 2 => true]));
	}
	
	public function test_has_BoolAndExists_ReturnTrue()
	{
		$subject = new BooleanIndex();
		$subject->add(1, true);
		
		self::assertTrue($subject->has(true));
	}
	
	public function test_has_BoolAndNotExists_ReturnFalse()
	{
		$subject = new BooleanIndex();
		
		self::assertFalse($subject->has(true));
	}
	
	public function test_has_NotBool_CastToBool()
	{
		$subject = new BooleanIndex();
		$subject->add(1, true);
		
		self::assertTrue($subject->has([1]));
	}
	
	
	public function test_hasAny_NonExist_ReturnFalse()
	{
		$subject = new BooleanIndex();
		
		self::assertFalse($subject->hasAny([true, false]));
	}
	
	public function test_hasAny_SomeExist_ReturnTrue()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true]);
		
		self::assertTrue($subject->hasAny([false, true]));
	}
	
	public function test_hasAny_AllExist_ReturnTrue()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => false]);
		
		self::assertTrue($subject->hasAny([true, false]));
	}
	
	public function test_hasAll_NonExist_ReturnFalse()
	{
		$subject = new BooleanIndex();
		
		self::assertFalse($subject->hasAll([true, false]));
	}
	
	public function test_hasAll_SomeExist_ReturnFalse()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true]);
		
		self::assertFalse($subject->hasAll([false, true]));
	}
	
	public function test_hasAll_AllExist_ReturnTrue()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => false]);
		
		self::assertTrue($subject->hasAll([true, false]));
	}
	
	public function test_add_ValueNotBool_CastToBool()
	{
		$subject = new BooleanIndex();
		
		self::assertTrue($subject->add(1, 1)->has(true));
	}
	
	public function test_add_RowIDExistInOppositeValue_RemoveFromOpposite()
	{
		$subject = new BooleanIndex();
		$subject->add(1, false);
		
		self::assertFalse($subject->add(1, true)->has(false));
	}
	
	public function test_add_RowIDNotExist_AddRowID()
	{
		$subject = new BooleanIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, true)->findValue(true));
	}
	
	public function test_addBulk_ValueNotExist_AddRowID()
	{
		$subject = new BooleanIndex();
		
		self::assertEquals([1 => 1], $subject->addBulk([1 => true])->findValue(true));
	}
	
	public function test_addBulk_ValueExistWithDifferentRowID_AddRowID()
	{
		$subject = new BooleanIndex();
		$subject->add(1, true);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->addBulk([2 => true])->findValue(true));
	}
	
	public function test_addBulk_AddAllRowIDs()
	{
		$subject = new BooleanIndex();
		
		self::assertEquals([1 => 1, 2 => 2], $subject->addBulk([1 => true, 2 => true])->findValue(true));
	}
	
	public function test_remRowIDs_RemoveRowIDsFromGivenInput()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => true, 3 => true]);
		$subject->remRowIDs([1 => true, 2 => true]);
		
		self::assertEquals([3 => 3], $subject->findValue(true));
	}
	
	public function test_remRowIDs_RowIDNotExistsWithValue_Ignore()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true]);
		$subject->remRowIDs([2 => true]);
		
		self::assertEquals([1 => 1], $subject->findValue(true));
	}
	
	public function test_remValue_RemoveBool_ReturnRowIDs()
	{
		$subject = new BooleanIndex();
		$subject->add(1, true);
		
		self::assertEquals([1 => 1], $subject->remValue(true));
	}
	
	public function test_remValue_RemoveBool_RemovesFromMap()
	{
		$subject = new BooleanIndex();
		$subject->add(1, true);
		$subject->remValue(true);
		
		self::assertEquals([], $subject->findValue(true));
	}
	
	public function test_remValues_ReturnAllRemoved()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => false]);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->remValues([true, false]));
	}
	
	public function test_findValue_ValueExists_ReturnRowIDs()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => true]);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue(true));
	}
	
	public function test_findValue_ValueNotExists_ReturnEmpty()
	{
		$subject = new BooleanIndex();
		
		self::assertEquals([], $subject->findValue(true));
	}
	
	public function test_findValues_ValueExists_ReturnRowIDs()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => true]);
		
		self::assertEquals([[1 => 1, 2 => 2]], $subject->findValues([true]));
	}
	
	public function test_findValues_ValueNotExists_ReturnEmptyForThatValue()
	{
		$subject = new BooleanIndex();
		
		self::assertEquals([[]], $subject->findValues([true]));
	}
	
	public function test_findValues_ValueExistTwice_ReturnRowIDsTwice()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => true]);
		
		self::assertEquals([[1 => 1, 2 => 2], [1 => 1, 2 => 2]], $subject->findValues([true, true]));
	}
	
	public function test_clear_ClearsMaps()
	{
		$subject = new BooleanIndex();
		$subject->addBulk([1 => true, 2 => false]);
		$subject->clear();
		
		self::assertFalse($subject->has(true));
		self::assertFalse($subject->has(false));
	}
}
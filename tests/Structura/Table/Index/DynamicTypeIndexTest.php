<?php
namespace Structura\Table\Index;


use PHPUnit\Framework\TestCase;


class DynamicTypeIndexTest extends TestCase
{
	public function test_ReturnSelf()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals($subject, $subject->add(1, 'test'));
		self::assertEquals($subject, $subject->addBulk([2 => 'test']));
		self::assertEquals($subject, $subject->remRowIDs([1 => 'test', 2 => 'test']));
	}
	
	public function test_has_TypeIntExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		
		self::assertTrue($subject->has(1));
	}
	
	public function test_has_TypeIntNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has(1));
	}
	
	public function test_has_TypeFloatRoundExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.0);
		
		self::assertTrue($subject->has(1.0));
	}
	
	public function test_has_TypeFloatRoundNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has(1.0));
	}
	
	public function test_has_TypeFloatExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.1);
		
		self::assertTrue($subject->has(1.1));
	}
	
	public function test_has_TypeFloatNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has(1.1));
	}
	
	public function test_has_TypeStringExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 'test');
		
		self::assertTrue($subject->has('test'));
	}
	
	public function test_has_TypeStringNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has('test'));
	}
	
	public function test_has_TypeBoolExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, true);
		
		self::assertTrue($subject->has(true));
	}
	
	public function test_has_TypeBoolNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has(true));
	}
	
	public function test_has_TypeNullExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, null);
		
		self::assertTrue($subject->has(null));
	}
	
	public function test_has_TypeNullNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has(null));
	}
	
	public function test_has_TypeArrayExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, [1]);
		
		self::assertTrue($subject->has([1]));
	}
	
	public function test_has_TypeArrayNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has([1]));
	}
	
	public function test_has_TypeObjectExists_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$o = new \stdClass();
		$subject->add(1, $o);
		
		self::assertTrue($subject->has($o));
	}
	
	public function test_has_TypeObjectNotExists_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->has(new \stdClass()));
	}
	
	public function test_hasAny_NonExist_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->hasAny([1, 2.2]));
	}
	
	public function test_hasAny_SomeExist_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(2, 2.2);
		
		self::assertTrue($subject->hasAny([1, 2.2]));
	}
	
	public function test_hasAny_AllExist_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		$subject->add(2, 2.2);
		
		self::assertTrue($subject->hasAny([1, 2.2]));
	}
	
	public function test_hasAll_NonExist_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->hasAll([1, 2.2]));
	}
	
	public function test_hasAll_SomeExist_ReturnFalse()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(2, 2.2);
		
		self::assertFalse($subject->hasAll([1, 2.2]));
	}
	
	public function test_hasAll_AllExist_ReturnTrue()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		$subject->add(2, 2.2);
		
		self::assertTrue($subject->hasAll([1, 2.2]));
	}
	
	public function test_add_RowIDExists_RemoveFormer()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 2);
		
		self::assertFalse($subject->add(1, 1)->has(2));
	}
	
	public function test_add_TypeInt_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, 1)->findValue(1));
	}
	
	public function test_add_TypeFloatRound_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, 1.0)->findValue(1.0));
	}
	
	public function test_add_TypeFloat_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, 1.1)->findValue(1.1));
	}
	
	public function test_add_TypeString_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, 'test')->findValue('test'));
	}
	
	public function test_add_TypeBool_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, false)->findValue(false));
	}
	
	public function test_add_TypeNull_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, null)->findValue(null));
	}
	
	public function test_add_TypeArray_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, [1])->findValue([1]));
	}
	
	public function test_add_TypeObject_SaveRowID()
	{
		$subject = new DynamicTypeIndex();
		$o = new \stdClass();
		
		self::assertEquals([1 => 1], $subject->add(1, $o)->findValue($o));
	}
	
	public function test_addBulk_MiscTypes_SavesAll()
	{
		$subject = new DynamicTypeIndex();
		$subject->addBulk([
			1 => 1,
			2 => 2.2,
			3 => 'test'
		]);
		
		self::assertTrue($subject->has(1));
		self::assertTrue($subject->has(2.2));
		self::assertTrue($subject->has('test'));
	}
	
	public function test_addBulk_DuplicateRowID_SavesLast()
	{
		$subject = new DynamicTypeIndex();
		$subject->addBulk([
			1 => 1
		]);
		$subject->addBulk([
			1 => 2
		]);
		
		self::assertFalse($subject->has(1));
		self::assertTrue($subject->has(2));
	}
	
	public function test_remRowIDs_TypeInt_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		
		self::assertFalse($subject->remRowIDs([1 => 1])->has(1));
	}
	
	public function test_remRowIDs_TypeFloatRound_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.0);
		
		self::assertFalse($subject->remRowIDs([1 => 1.0])->has(1.0));
	}
	
	public function test_remRowIDs_TypeFloat_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.1);
		
		self::assertFalse($subject->remRowIDs([1 => 1.1])->has(1.1));
	}
	
	public function test_remRowIDs_TypeString_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 'test');
		
		self::assertFalse($subject->remRowIDs([1 => 'test'])->has('test'));
	}
	
	public function test_remRowIDs_TypeBool_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, true);
		
		self::assertFalse($subject->remRowIDs([1 => true])->has(true));
	}
	
	public function test_remRowIDs_TypeNull_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, null);
		
		self::assertFalse($subject->remRowIDs([1 => null])->has(null));
	}
	
	public function test_remRowIDs_TypeArray_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, [1]);
		
		self::assertFalse($subject->remRowIDs([1 => [1]])->has([1]));
	}
	
	public function test_remRowIDs_TypeObject_RemoveRowID()
	{
		$subject = new DynamicTypeIndex();
		$o = new \stdClass();
		$subject->add(1, $o);
		
		self::assertFalse($subject->remRowIDs([1 => $o])->has($o));
	}
	
	public function test_remRowIDs_RowIDInDifferentType_NotRemoves()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		$subject->add(2, 2);
		
		self::assertTrue($subject->remRowIDs([2 => 1])->has(2));
	}
	
	public function test_remRowIDs_TypeObjectNotExists_Ignore()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertFalse($subject->remRowIDs([1 => 1])->has(1));
	}
	
	public function test_remValue_TypeIntExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		
		self::assertEquals([1 => 1], $subject->remValue(1));
	}
	
	public function test_remValue_TypeIntNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->remValue(1));
	}
	
	public function test_remValue_TypeFloatRoundExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.0);
		
		self::assertEquals([1 => 1], $subject->remValue(1.0));
	}
	
	public function test_remValue_TypeFloatRoundNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->remValue(1.0));
	}
	
	public function test_remValue_TypeFloatExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.1);
		
		self::assertEquals([1 => 1], $subject->remValue(1.1));
	}
	
	public function test_remValue_TypeFloatNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->remValue(1.1));
	}
	
	public function test_remValue_TypeStringExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 'test');
		
		self::assertEquals([1 => 1], $subject->remValue('test'));
	}
	
	public function test_remValue_TypeStringNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->remValue('test'));
	}
	
	public function test_remValue_TypeBoolExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, true);
		
		self::assertEquals([1 => 1], $subject->remValue(true));
	}
	
	public function test_remValue_TypeBoolNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->remValue(true));
	}
	
	public function test_remValue_TypeNullExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, null);
		
		self::assertEquals([1 => 1], $subject->remValue(null));
	}
	
	public function test_remValue_TypeNullNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->remValue(null));
	}
	
	public function test_remValue_TypeArrayExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, [1]);
		
		self::assertEquals([1 => 1], $subject->remValue([1]));
	}
	
	public function test_remValue_TypeArrayNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->remValue([1]));
	}
	
	public function test_remValue_TypeObjectExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$o = new \stdClass();
		$subject->add(1, $o);
		
		self::assertEquals([1 => 1], $subject->remValue($o));
	}
	
	public function test_remValue_TypeObjectNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		$o = new \stdClass();
		
		self::assertEquals([], $subject->remValue($o));
	}
	
	public function test_remValues_ReturnAllRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		$subject->add(2, 1);
		$subject->add(3, 2);
		$subject->add(4, 2);
		
		self::assertEquals([1 => 1, 2 => 2, 3 => 3, 4 => 4], $subject->remValues([1, 2]));
	}
	
	public function test_findValue_TypeIntExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		$subject->add(2, 1);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue(1));
	}
	
	public function test_findValue_TypeIntNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue(1));
	}
	
	public function test_findValue_TypeFloatRoundExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.0);
		$subject->add(2, 1.0);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue(1.0));
	}
	
	public function test_findValue_TypeFloatRoundNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue(1.0));
	}
	
	public function test_findValue_TypeFloatExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1.1);
		$subject->add(2, 1.1);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue(1.1));
	}
	
	public function test_findValue_TypeFloatNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue(1.1));
	}
	
	public function test_findValue_TypeStringExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 'test');
		$subject->add(2, 'test');
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue('test'));
	}
	
	public function test_findValue_TypeStringNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue('test'));
	}
	
	public function test_findValue_TypeBoolExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, true);
		$subject->add(2, true);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue(true));
	}
	
	public function test_findValue_TypeBoolNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue(true));
	}
	
	public function test_findValue_TypeNullExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, null);
		$subject->add(2, null);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue(null));
	}
	
	public function test_findValue_TypeNullNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue(null));
	}
	
	public function test_findValue_TypeArrayExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, [1]);
		$subject->add(2, [1]);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue([1]));
	}
	
	public function test_findValue_TypeArrayNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue([1]));
	}
	
	public function test_findValue_TypeObjectExists_ReturnRowIDs()
	{
		$subject = new DynamicTypeIndex();
		$o = new \stdClass();
		$subject->add(1, $o);
		$subject->add(2, $o);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue($o));
	}
	
	public function test_findValue_TypeObjectNotExists_ReturnEmpty()
	{
		$subject = new DynamicTypeIndex();
		
		self::assertEquals([], $subject->findValue(new \stdClass()));
	}
	
	public function test_findValues_ReturnMapped()
	{
		$subject = new DynamicTypeIndex();
		$subject->add(1, 1);
		$subject->add(2, 1);
		$subject->add(3, 2.2);
		$subject->add(4, 2.2);
		$subject->add(5, 'test');
		$subject->add(6, 'test');
		
		self::assertEquals([[1 => 1, 2 => 2], [3 => 3, 4 => 4], [5 => 5, 6 => 6]], $subject->findValues([1, 2.2, 'test']));
	}
	
	public function test_clear_ClearsAll()
	{
		$subject = new DynamicTypeIndex();
		$o = new \stdClass();
		$subject->addBulk([
			1 => 1,
			2 => 2.0,
			3 => 3.3,
			4 => 'test',
			5 => true,
			6 => [1, 2],
			7 => $o,
			8 => null
		]);
		
		$subject->clear();
		
		self::assertFalse($subject->hasAny([
			1, 2.0, 3.3, 'test', true, [1, 2], $o, null
		]));
	}
}
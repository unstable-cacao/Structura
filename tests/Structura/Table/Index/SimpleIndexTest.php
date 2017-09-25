<?php
namespace Structura\Table\Index;


use PHPUnit\Framework\TestCase;


class SimpleIndexTest extends TestCase
{
	public function test_ReturnSelf()
	{
		$subject = new SimpleIndex();
		
		self::assertEquals($subject, $subject->add(1, 'test'));
		self::assertEquals($subject, $subject->addBulk([2 => 'test']));
		self::assertEquals($subject, $subject->remRowIDs([1 => 'test', 2 => 'test']));
	}
	
	
	public function test_has_Exists_ReturnTrue()
	{
		$subject = new SimpleIndex();
		$subject->add(1, 'test');
		
		self::assertTrue($subject->has('test'));
	}
	
	public function test_has_NotExists_ReturnFalse()
	{
		$subject = new SimpleIndex();
		
		self::assertFalse($subject->has('test'));
	}
	
	public function test_hasAny_HasNone_ReturnFalse()
	{
		$subject = new SimpleIndex();
		
		self::assertFalse($subject->hasAny(['test', 3]));
	}
	
	public function test_hasAny_HasSome_ReturnTrue()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([2 => 3]);
		
		self::assertTrue($subject->hasAny(['test', 3]));
	}
	
	public function test_hasAny_HasAll_ReturnTrue()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([1 => 'test', 2 => 3]);
		
		self::assertTrue($subject->hasAny(['test', 3]));
	}
	
	public function test_hasAll_HasNone_ReturnFalse()
	{
		$subject = new SimpleIndex();
		
		self::assertFalse($subject->hasAll(['test', 3]));
	}
	
	public function test_hasAll_HasSome_ReturnFalse()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([2 => 3]);
		
		self::assertFalse($subject->hasAll(['test', 3]));
	}
	
	public function test_hasAll_HasAll_ReturnTrue()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([1 => 'test', 2 => 3]);
		
		self::assertTrue($subject->hasAll(['test', 3]));
	}
	
	
	public function test_add_ValueNotExists_AddsValueWithRowID()
	{
		$subject = new SimpleIndex();
		
		self::assertEquals([1 => 1], $subject->add(1, 'test')->findValue('test'));
	}
	
	public function test_add_RowIDInOtherValue_RemoveRowIDFromOther()
	{
		$subject = new SimpleIndex();
		$subject->add(1, 'pos');
		
		self::assertFalse($subject->add(1, 'test')->has('pos'));
	}
	
	public function test_add_ValueExists_AddRowIDToValue()
	{
		$subject = new SimpleIndex();
		$subject->add(1, 'test');
		
		self::assertEquals([1 => 1, 2 => 2], $subject->add(2, 'test')->findValue('test'));
	}
	
	public function test_addBulk_AddAllValues()
	{
		$subject = new SimpleIndex();
		
		self::assertEquals([1 => 1, 2 => 2], $subject->addBulk([1 => 'test', 2 => 'test'])->findValue('test'));
	}
	
	
	public function test_remRowIDs_RowNotExists_Ignore()
	{
		$subject = new SimpleIndex();
		$subject->add(2, 'test');
		
		self::assertEquals([2 => 2], $subject->remRowIDs([1 => 'test'])->findValue('test'));
	}
	
	public function test_remRowIDs_ValueNotExists_Ignore()
	{
		$subject = new SimpleIndex();
		
		self::assertFalse($subject->remRowIDs([1 => 'test'])->has('test'));
	}
	
	public function test_remRowIDs_LastRowIDOfValue_RemoveValue()
	{
		$subject = new SimpleIndex();
		$subject->add(1, 'test');
		
		self::assertFalse($subject->remRowIDs([1 => 'test'])->has('test'));
	}
	
	public function test_remRowIDs_NotLastRowIDOfValue_RemoveRowIDOnly()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([1 => 'test', 2 => 'test']);
		
		self::assertEquals([2 => 2], $subject->remRowIDs([1 => 'test'])->findValue('test'));
	}
	
	public function test_remValue_ValueNotExist_ReturnEmpty()
	{
		$subject = new SimpleIndex();
		
		self::assertEquals([], $subject->remValue('test'));
	}
	
	public function test_remValue_ValueExists_ReturnItsRowIDs()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([1 => 'test', 2 => 'test']);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->remValue('test'));
	}
	
	public function test_remValues_ReturnAllRowIDs()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([1 => 'test', 2 => 1]);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->remValues(['test', 1]));
	}
	
	
	public function test_findValue_ValueExists_ReturnValueRowIDs()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([1 => 'test', 2 => 'test']);
		
		self::assertEquals([1 => 1, 2 => 2], $subject->findValue('test'));
	}
	
	public function test_findValue_ValueNotExist_ReturnEmpty()
	{
		$subject = new SimpleIndex();
		
		self::assertEquals([], $subject->findValue('test'));
	}
	
	public function test_findValues_ReturnRowIDs()
	{
		$subject = new SimpleIndex();
		$subject->addBulk([1 => 'test', 2 => 2]);
		
		self::assertEquals([[1 => 1], [2 => 2]], $subject->findValues(['test', 2]));
	}
	
	
	public function test_clear_ClearsMap()
	{
		$subject = new SimpleIndex();
		$subject->add(1, 'test');
		
		$subject->clear();
		
		self::assertFalse($subject->has('test'));
	}
}
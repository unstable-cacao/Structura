<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class MapTest extends TestCase
{
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_add_KeyNotValid_ExceptionThrown()
	{
		$subject = new Map();
		$subject->add([], 1);
	}
	
	public function test_add_KeyValid_AddValueToMap()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		self::assertTrue($subject->has(1));
	}
	
	public function test_add_KeyExists_OverwriteOldValue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add(1, 2);
		
		self::assertEquals(2, $subject->get(1));
	}
	
	public function test_add_TransformExists_TransformCalled()
	{
		$subject = new Map();
		$called = false;
		$subject->setTransform(function($key) use (&$called) {
			$called = true;
			return ++$key;
		});
		
		$subject->add(1, 1);
		
		self::assertEquals(1, $subject->get(1));
		self::assertTrue($called);
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_remove_KeyNotValid_ExceptionThrown()
	{
		$subject = new Map();
		$subject->remove([]);
	}
	
	public function test_remove_KeyNotExists_Ignore()
	{
		$subject = new Map();
		$subject->add(2, 2);
		$subject->remove(1);
		
		self::assertEquals(1, $subject->count());
	}
	
	public function test_remove_KeyExists_RemoveFromMap()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->remove(1);
		
		self::assertFalse($subject->has(1));
	}
	
	public function test_remove_TransformExists_TransformCalled()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		$called = false;
		
		$subject->setTransform(function($key) use (&$called) {
			$called = true;
			return $key;
		});
		
		$subject->remove(1);
		
		self::assertTrue($called);
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_get_KeyNotValid_ExceptionThrown()
	{
		$subject = new Map();
		$subject->get([]);
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_get_KeyNotExists_ExceptionThrown()
	{
		$subject = new Map();
		$subject->get(1);
	}
	
	public function test_get_KeyExists_ReturnValue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		self::assertEquals(1, $subject->get(1));
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_tryGet_KeyNotValid_ExceptionThrown()
	{
		$subject = new Map();
		$subject->tryGet([], $value);
	}
	
	public function test_tryGet_KeyExists_ReturnTrue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		self::assertTrue($subject->tryGet(1, $value));
	}
	
	public function test_tryGet_TransformExists_TransformCalled()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$called = false;
		
		$subject->setTransform(function($key) use (&$called) {
			$called = true;
			return $key;
		});
		
		$subject->tryGet(1, $value);
		
		self::assertTrue($called);
	}
	
	public function test_tryGet_KeyExists_SetsValue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->tryGet(1, $value);
		
		self::assertEquals(1, $value);
	}
	
	public function test_tryGet_KeyNotExists_ReturnFalse()
	{
		$subject = new Map();
		
		self::assertFalse($subject->tryGet(1, $value));
	}
	
	public function test_tryGet_KeyNotExists_SetsNull()
	{
		$subject = new Map();
		$subject->tryGet(1, $value);
		
		self::assertNull($value);
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_has_KeyNotValid_ExceptionThrown()
	{
		$subject = new Map();
		$subject->has([]);
	}
	
	public function test_has_KeyExists_ReturnTrue()
	{
		$subject = new Map();
		$subject->add(1,1);
		
		self::assertTrue($subject->has(1));
	}
	
	public function test_has_TransformExists_TransformCalled()
	{
		$subject = new Map();
		$subject->add(1,1);
		$called = false;
		
		$subject->setTransform(function($key) use (&$called) {
			$called = true;
			return $key;
		});
		
		$subject->has(1);
		
		self::assertTrue($called);
	}
	
	public function test_has_KeyNotExists_ReturnFalse()
	{
		$subject = new Map();
		
		self::assertFalse($subject->has(1));
	}
	
	public function test_hasAny_NoneExist_ReturnFalse()
	{
		$subject = new Map();
		
		self::assertFalse($subject->hasAny([1, 2, 'test']));
	}
	
	public function test_hasAny_SomeExist_ReturnTrue()
	{
		$subject = new Map();
		$subject->add(2, 2);
		$subject->add('test', 3);
		
		self::assertTrue($subject->hasAny([1, 2, 'test']));
	}
	
	public function test_hasAny_AllExist_ReturnTrue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add(2, 2);
		$subject->add('test', 3);
		
		self::assertTrue($subject->hasAny([1, 2, 'test']));
	}
	
	public function test_hasAll_NoneExist_ReturnFalse()
	{
		$subject = new Map();
		
		self::assertFalse($subject->hasAll([1, 2, 'test']));
	}
	
	public function test_hasAll_SomeExist_ReturnFalse()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add('test', 3);
		
		self::assertFalse($subject->hasAll([1, 2, 'test']));
	}
	
	public function test_hasAll_AllExist_ReturnTrue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add('test', 3);
		$subject->add(2, 2);
		
		self::assertTrue($subject->hasAll([1, 2, 'test']));
	}
	
	public function test_count_MapEmpty_ReturnZero()
	{
		$subject = new Map();
		
		self::assertEquals(0, $subject->count());
	}
	
	public function test_count_MapNotEmpty_ReturnCount()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add(2, 2);
		$subject->add(3, 3);
		
		self::assertEquals(3, $subject->count());
	}
	
	public function test_clear_Clears()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add(2, 2);
		$subject->add(3, 3);
		$subject->clear();
		
		self::assertEquals(0, $subject->count());
	}
	
	public function test_getIterator_ForeachPossible()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		foreach ($subject as $key => $item) 
		{
			self::assertEquals(1, $key);
			self::assertEquals(1, $item);
		}
	}
	
	public function test_offsetExists_Exists_ReturnTrue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		self::assertTrue(isset($subject[1]));
	}
	
	public function test_offsetExists_NotExists_ReturnFalse()
	{
		$subject = new Map();
		
		self::assertFalse(isset($subject[1]));
	}
	
	public function test_offsetGet_Exists_GetsFromMap()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		self::assertEquals(1, $subject[1]);
	}
	
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_offsetGet_NotExists_ExceptionThrown()
	{
		$subject = new Map();
		$subject[[]];
	}
	
	public function test_offsetSet_SetsToMap()
	{
		$subject = new Map();
		$subject[1] = 1;
		
		self::assertEquals(1, $subject->get(1));
	}
	
	public function test_offsetSet_AlreadyExists_OverwritesOldValue()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject[1] = 2;
		
		self::assertEquals(2, $subject->get(1));
	}
	
	public function test_offsetUnset_RemovesFromMap()
	{
		$subject = new Map();
		$subject->add(1, 1);
		unset($subject[1]);
		
		self::assertFalse($subject->has(1));
	}
	
	public function test_keys_EmptyMap_ReturnEmpty()
	{
		$subject = new Map();
		
		self::assertEmpty($subject->keys());
	}
	
	public function test_keys_ReturnKeys()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add(2, 1);
		
		self::assertEquals([1, 2], $subject->keys());
	}
	
	public function test_values_EmptyMap_ReturnEmpty()
	{
		$subject = new Map();
		
		self::assertEmpty($subject->values());
	}
	
	public function test_values_ReturnValues()
	{
		$subject = new Map();
		$subject->add(1, 1);
		$subject->add(2, 1);
		$subject->add(3, 'test');
		
		self::assertEquals([1, 1, 'test'], $subject->values());
	}
	
	public function test_keysSet_ReturnSetObject()
	{
		$subject = new Map();
		$subject->add(1, 1);
		
		self::assertInstanceOf(Set::class, $subject->keysSet());
	}
}
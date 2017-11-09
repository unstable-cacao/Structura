<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class MapTest extends TestCase
{
	public function test_returnSelf()
	{
		$subject = new Map();
		
		self::assertEquals($subject, $subject->merge([1 => 1]));
		self::assertEquals($subject, $subject->intersect([1 => 1]));
		self::assertEquals($subject, $subject->diff([]));
	}
	
	public function test_construct_SetMap()
	{
		$subject = new Map([1 => 1]);
		
		self::assertTrue($subject->has(1));
	}
	
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
		$subject->add(1, 1);
		
		self::assertTrue($subject->has(1));
	}
	
	public function test_has_TransformExists_TransformCalled()
	{
		$subject = new Map();
		$subject->add(1, 1);
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
		
		foreach ($subject as $key => $item) {
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
	
	public function test_merge_Empty_NothingChanged()
	{
		$subject = new Map([1 => 2]);
		$subject->merge([]);
		
		self::assertEquals([1 => 2], $subject->toArray());
	}
	
	public function test_merge_UniqueKeys_Merges()
	{
		$subject = new Map([1 => 2]);
		$subject->merge([2 => 2]);
		
		self::assertEquals([1 => 2, 2 => 2], $subject->toArray());
	}
	
	public function test_merge_KeyExists_Overwrites()
	{
		$subject = new Map([1 => 2]);
		$subject->merge([1 => 3]);
		
		self::assertEquals([1 => 3], $subject->toArray());
	}
	
	public function test_intersect_Empty_SetEmpty()
	{
		$subject = new Map([1 => 2]);
		$subject->intersect([]);
		
		self::assertEquals([], $subject->toArray());
	}
	
	public function test_intersect_IntersectByKey()
	{
		$subject = new Map([1 => 1, 2 => 2, 3 => 3]);
		$subject->intersect([1 => 3, 3 => 5], new Map([3 => 9]), new Set([1, 2, 3, 4]));
		
		self::assertEquals([3 => 3], $subject->toArray());
	}
	
	public function test_diff_Empty_NothingChanged()
	{
		$subject = new Map([1 => 2]);
		$subject->diff([]);
		
		self::assertEquals([1 => 2], $subject->toArray());
	}
	
	public function test_diff_DiffByKey()
	{
		$subject = new Map([1 => 1, 2 => 2, 3 => 3]);
		$subject->diff([5], new Map([3 => 9]), new Set([1, 2, 3, 4]));
		
		self::assertEquals([], $subject->toArray());
	}
	
	public function test_symmetricDiff_Empty_NothingChanged()
	{
		$subject = new Map([1 => 2]);
		$subject->symmetricDiff([]);
		
		self::assertEquals([1 => 2], $subject->toArray());
	}
	
	public function test_symmetricDiff_XorByKey()
	{
		$subject = new Map([1 => 1, 2 => 2, 8 => 3]);
		$subject->symmetricDiff([5], new Map([5 => 9]), new Set([1, 2, 3, 4]));
		
		self::assertEquals([8 => 3, 5 => 9, 3 => 4], $subject->toArray());
	}
	
	public function test_toArray_ReturnMap()
	{
		$subject = new Map([1 => 2]);
		
		self::assertEquals([1 => 2], $subject->toArray());
	}
	
	
	public function test_hasElements_EmptyMap_ReturnFalse()
	{
		$subject = new Map();
		self::assertFalse($subject->hasElements());
	}
	
	public function test_hasElements_NonEmptySet_ReturnTrue()
	{
		$subject = new Map([1]);
		self::assertTrue($subject->hasElements());
	}
	
	
	public function test_mergeMap_NoParams_EmptyMap()
	{
		$map = Map::mergeMap();
		
		self::assertEquals([], $map->toArray());
	}
	
	public function test_mergeMap_OneParam_Map()
	{
		$map = Map::mergeMap([1 => 1]);
		
		self::assertEquals([1 => 1], $map->toArray());
	}
	
	public function test_mergeMap_MergedMap()
	{
		$map = Map::mergeMap([1 => 1], new Map([2 => 2]), new Set([3 => 3]));
		
		self::assertEquals([1 => 1, 2 => 2, 3 => 3], $map->toArray());
	}
	
	public function test_intersectMap_NoParams_EmptyMap()
	{
		$map = Map::intersectMap();
		
		self::assertEquals([], $map->toArray());
	}
	
	public function test_intersectMap_OneParam_Map()
	{
		$map = Map::intersectMap([2 => 2]);
		
		self::assertEquals([2 => 2], $map->toArray());
	}
	
	public function test_intersectMap_IntersectedMap()
	{
		$map = Map::intersectMap([1 => 1, 2 => 2], new Map([2 => 2]), new Set([1, 2, 3]));
		
		self::assertEquals([2 => 2], $map->toArray());
	}
	
	public function test_diffMap_NoParams_EmptyMap()
	{
		$map = Map::diffMap();
		
		self::assertEquals([], $map->toArray());
	}
	
	public function test_diffMap_OneParam_Map()
	{
		$map = Map::diffMap([3 => 3]);
		
		self::assertEquals([3 => 3], $map->toArray());
	}
	
	public function test_diffMap_DiffMap()
	{
		$map = Map::diffMap([1 => 1], new Map([2 => 2]), new Set([3 => 3]));
		
		self::assertEquals([1 => 1], $map->toArray());
	}
	
	public function test_symmetricDiffMap_NoParams_EmptyMap()
	{
		$map = Map::symmetricDiffMap();
		
		self::assertEquals([], $map->toArray());
	}
	
	public function test_symmetricDiffMapp_OneParam_Map()
	{
		$map = Map::symmetricDiffMap([3 => 3]);
		
		self::assertEquals([3 => 3], $map->toArray());
	}
	
	public function test_symmetricDiffMap_DiffMap()
	{
		$map = Map::symmetricDiffMap([1 => 1], new Map([2 => 2]), new Set([3]));
		
		self::assertEquals([1 => 1, 2 => 2, 0 => 3], $map->toArray());
	}
}
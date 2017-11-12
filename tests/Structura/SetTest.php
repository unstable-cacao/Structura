<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class SetTest extends TestCase
{
	public function test_isEmpty_EmptySet_ReturnTrue()
	{
		$set = new Set();
		self::assertTrue($set->isEmpty());
	}
	
	public function test_isEmpty_NonEmptySet_ReturnFalse()
	{
		$set = new Set([1]);
		self::assertFalse($set->isEmpty());
	}
	
	
	public function test_hasElements_EmptySet_ReturnFalse()
	{
		$set = new Set();
		self::assertFalse($set->hasElements());
	}
	
	public function test_hasElements_NonEmptySet_ReturnTrue()
	{
		$set = new Set([1]);
		self::assertTrue($set->hasElements());
	}
	
	
	public function test_count_EmptySet_ReturnZero()
	{
		$set = new Set();
		self::assertEquals(0, $set->count());
	}
	
	public function test_count_NonEmptySet_ReturnNumberOfElements()
	{
		$set = new Set();
		
		$set->add(1);
		$set->add(2);
		
		self::assertEquals(2, $set->count());
	}
	
	
	public function test_clone_ByValueClonedCorrectly()
	{
		$set = new Set();
		$set->add(1);
		
		$clone = clone $set;
		$clone->add(2);
		
		self::assertTrue($clone->has(1));
		self::assertFalse($set->has(2));
	}
	
	public function test_clone_ByReferenceNotCloned()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public $a = 1;
			public function getHashCode() { return 'a'; }
		};
		
		$set->add($object);
		
		$clone = clone $set;
		
		foreach ($clone as $value)
		{
			$value->a = 2;
		}
		
		self::assertEquals(2, $object->a);
	}
	
	
	public function test_deepClone_ByValueClonedCorrectly()
	{
		$set = new Set();
		$set->add(1);
		
		$clone = $set->deepClone();
		$clone->add(2);
		
		self::assertTrue($clone->has(1));
		self::assertFalse($set->has(2));
	}
	
	public function test_deepClone_ByReferenceCloned()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public $a = 1;
			public function getHashCode() { return 'a'; }
		};
		
		$set->add($object);
		
		$clone = $set->deepClone();
		
		foreach ($clone as $value)
		{
			$value->a = 2;
		}
		
		self::assertEquals(1, $object->a);
	}
	
	
	public function test_has_EmptySet_ReturnFalse()
	{
		$set = new Set();
		self::assertFalse($set->has(2));
	}
	
	public function test_has_NotFound_ReturnFalse()
	{
		$set = new Set();
		$set->add(1);
		self::assertFalse($set->has(2));
	}
	
	public function test_has_Found_ReturnTrue()
	{
		$set = new Set();
		$set->add(1);
		self::assertTrue($set->has(1));
	}
	
	public function test_has_FoundIIdentified_ReturnTrue()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		
		$set->add($object);
		self::assertTrue($set->has($object));
	}
	
	
	public function test_toArray_EmptySet_ReturnEmptyArray()
	{
		$set = new Set();
		self::assertEmpty($set->toArray());
	}
	
	public function test_toArray_HasItems_ReturnItems()
	{
		$set = new Set();
		$set->add(1, 2, 3);
		self::assertEquals([1, 2, 3], $set->toArray());
	}
	
	public function test_toArray_HasObject_ObjectReturned()
	{
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		
		$set = new Set();
		$set->add($object);
		self::assertEquals([$object], $set->toArray());
	}
	
	
	public function test_foreach_EmptySet_NotCalled()
	{
		$set = new Set();
		
		foreach ($set as $value)
		{
			self::fail();
		}
		
		self::assertTrue(true);
	}
	
	public function test_foreach_HasItems_ItemsIterated()
	{
		$set = new Set();
		$set->add(1, 2, 3);
		self::assertEquals([1, 2, 3], $set->toArray());
	}
	
	public function test_foreach_HasItems_ItemsUsedAsValues()
	{
		$set = new Set();
		$set->add(1, 2, 3);
		$result = [];
		
		foreach ($set as $value)
		{
			$result[] = $value;
		}
		
		self::assertEquals([1, 2, 3], $result);
	}
	
	public function test_foreach_HasItems_ItemsUsedAsKeys()
	{
		$set = new Set();
		$set->add(1, 'a', 3);
		$result = [];
		
		foreach ($set as $key => $t)
		{
			$result[] = $key;
		}
		
		self::assertEquals([1, 'a', 3], $result);
	}
	
	public function test_foreach_HasObjects_ObjectPassedInValueAndItsKeyAsKey()
	{
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		
		$set = new Set();
		$set->add($object);
		$result = [];
		
		foreach ($set as $key => $t)
		{
			$result[$key] = $t;
		}
		
		self::assertEquals(['a' => $object], $result);
	}
	
	
	public function test_isset_EmptySet_ReturnFalse()
	{
		$set = new Set();
		self::assertFalse(isset($set[2]));
	}
	
	public function test_isset_NotFound_ReturnFalse()
	{
		$set = new Set();
		$set->add(1);
		self::assertFalse(isset($set[2]));
	}
	
	public function test_isset_Found_ReturnTrue()
	{
		$set = new Set();
		$set->add(1);
		self::assertTrue(isset($set[1]));
	}
	
	
	public function test_offsetGet_EmptySet_ReturnFalse()
	{
		$set = new Set();
		self::assertFalse($set[2]);
	}
	
	public function test_offsetGet_NotFound_ReturnFalse()
	{
		$set = new Set();
		$set->add(1);
		self::assertFalse($set[2]);
	}
	
	public function test_offsetGet_Found_ReturnTrue()
	{
		$set = new Set();
		$set->add(1);
		self::assertTrue($set[1]);
	}
	
	
	public function test_offsetSet_EmptySet_ItemAdded()
	{
		$set = new Set();
		$set[1] = true;
		self::assertTrue($set->has(1));
	}
	
	public function test_offsetSet_NotEmptySet_ItemAdded()
	{
		$set = new Set();
		$set->add(2, 3);
		
		$set[1] = true;
		
		self::assertTrue($set->has(1));
		self::assertTrue($set->has(2));
		self::assertTrue($set->has(3));
	}
	
	public function test_offsetSet_ItemAlreadyExists()
	{
		$set = new Set();
		$set->add(1);
		
		$set[1] = true;
		
		self::assertTrue($set[1]);
	}
	
	public function test_offsetSet_PassedValueIsFalseLike_ItemUnset()
	{
		$set = new Set();
		$set->add(1, 2, 3, 4);
		
		$set[1] = false;
		$set[2] = null;
		$set[3] = '';
		$set[4] = 0;
		
		self::assertFalse($set->has(1));
		self::assertFalse($set->has(2));
		self::assertFalse($set->has(3));
		self::assertFalse($set->has(4));
	}
	
	public function test_offsetSet_PassedBValueTreatedAsTrueLike()
	{
		$set = new Set();
		
		$set['b'] = 'a';
		
		$result = [];
		
		foreach ($set as $key => $value)
		{
			$result[$key] = $value;
		}
		
		self::assertEquals(['b' => 'b'], $result);
	}
	
	
	public function test_offsetUnset_EmptySet_Sanity()
	{
		$set = new Set();
		unset($set[1]);
		
		self::assertFalse($set->has(1));
	}
	
	public function test_offsetUnset_ItemNotExists_OtherItemsNotAffected()
	{
		$set = new Set();
		$set->add(1);
		unset($set[2]);
		self::assertTrue($set[1]);
	}
	
	public function test_offsetUnset_ItemExists_ItemUnset()
	{
		$set = new Set();
		$set->add(1);
		unset($set[1]);
		self::assertFalse($set[1]);
	}
	
	
	public function test_hasAny_HasAll_ReturnTrue()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		
		$set->add($object);
		$set->add(1);
		
		self::assertTrue($set->hasAny([$object, 1]));
	}
	
	public function test_hasAny_HasSome_ReturnTrue()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		
		$set->add($object);
		$set->add(1);
		
		self::assertTrue($set->hasAny([$object, 2]));
	}
	
	public function test_hasAny_HasNone_ReturnFalse()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		$object2 = new class implements IIdentified
		{
			public function getHashCode() { return 'b'; }
		};
		
		$set->add($object);
		$set->add(1);
		
		self::assertFalse($set->hasAny([$object2, 2]));
	}
	
	
	public function test_hasAll_HasAll_ReturnTrue()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		
		$set->add($object);
		$set->add(1);
		
		self::assertTrue($set->hasAll([$object, 1]));
	}
	
	public function test_hasAll_HasSome_ReturnFalse()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		
		$set->add($object);
		$set->add(1);
		
		self::assertFalse($set->hasAll([$object, 2]));
	}
	
	public function test_hasAll_HasNone_ReturnFalse()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			public function getHashCode() { return 'a'; }
		};
		$object2 = new class implements IIdentified
		{
			public function getHashCode() { return 'b'; }
		};
		
		$set->add($object);
		$set->add(1);
		
		self::assertFalse($set->hasAll([$object2, 2]));
	}
	
	
	/**
	 * @expectedException \Structura\Exceptions\InvalidValueException
	 */
	public function test_add_NotValid_ExceptionThrown()
	{
		$set = new Set();
		$object = new class {};
		
		$set->add($object);
	}
	
	public function test_add_Traversable_AddsAll()
	{
		$set = new Set();
		$object = new class implements \IteratorAggregate
		{
			public function getIterator()
			{
				return new \ArrayIterator([1, 2, 3]);
			}
		};
		
		$set->add($object);
		
		self::assertEquals([1, 2, 3], $set->toArray());
	}
	
	public function test_add_Identified_AddsIdentified()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			/**
			 * @return string|int
			 */
			public function getHashCode()
			{
				return 1;
			}
		};
		
		$set->add($object);
		
		self::assertEquals([$object], $set->toArray());
	}
	
	public function test_add_Scalar_AddsScalar()
	{
		$set = new Set();
		$set->add(1);
		
		self::assertEquals([1], $set->toArray());
	}
	
	public function test_add_AddAlreadyExisting_SetStaysUniqueValued()
	{
		$set = new Set();
		$set->add([11, 11, 12, 13, 11]);
		
		self::assertEquals([11, 12, 13], $set->toArray());
	}
	
	
	/**
	 * @expectedException \Structura\Exceptions\InvalidValueException
	 */
	public function test_rem_NotValid_ExceptionThrown()
	{
		$set = new Set();
		$object = new class {};
		
		$set->rem($object);
	}
	
	public function test_rem_Traversable_RemovesAll()
	{
		$set = new Set();
		$object = new class implements \IteratorAggregate
		{
			public function getIterator()
			{
				return new \ArrayIterator([1, 2, 3]);
			}
		};
		
		$set->add([1, 2, 3, 4]);
		$set->rem($object);
		
		self::assertEquals([4], $set->toArray());
	}
	
	public function test_rem_Identified_RemovesIdentified()
	{
		$set = new Set();
		$object = new class implements IIdentified
		{
			/**
			 * @return string|int
			 */
			public function getHashCode()
			{
				return 1;
			}
		};
		
		$set->add($object);
		
		self::assertEquals([$object], $set->toArray());
	}
	
	public function test_rem_Scalar_RemovesScalar()
	{
		$set = new Set();
		$set->add([1, 2, 3]);
		
		$set->rem(1);
		
		self::assertEquals([2, 3], $set->toArray());
	}
	
	
	public function test_clear_ClearsSet()
	{
		$set = new Set();
		$set->add([1, 2, 3]);
		
		$set->clear();
		
		self::assertTrue($set->isEmpty());
	}
	
	
	public function test_merge_AddsValue()
	{
		$set = new Set();
		$set->add([1, 2, 3]);
		
		$set->merge([2, 3, 4, 5]);
		
		self::assertEquals([1, 2, 3, 4, 5], $set->toArray());
	}
	
	
	public function test_intersect()
	{
		$set = new Set();
		$set->add([1, 2, 3]);
		
		$set->intersect([1, 5, 8], new Map([1 => 1]));
		
		self::assertEquals([1], $set->toArray());
	}
	
	public function test_diff()
	{
		$set = new Set();
		$set->add([1, 2, 3]);
		
		$set->diff([2, 3], [3, 5]);
		
		self::assertEquals([1], $set->toArray());
	}
	
	public function test_symmetricDiff()
	{
		$set = new Set();
		$set->add([1, 2, 3]);
		
		$set->symmetricDiff([2, 3], [5]);
		
		self::assertEquals([1, 5], $set->toArray());
	}
}


class SetTestHelper_Iterable implements \IteratorAggregate
{
	/**
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return \Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 * @since 5.0.0
	 */
	public function getIterator()
	{
		return new \ArrayIterator([1 => 15, 16 => 16]);
	}
}
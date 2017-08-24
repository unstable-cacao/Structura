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
		$set = new Set(1);
		self::assertFalse($set->isEmpty());
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
		
		$clone = clone $set;
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
		
		$clone = clone $set;
		
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
	}
	
	public function test_foreach_HasItems_ItemsIterated()
	{
		$set = new Set();
		$set->add(1, 2, 3);
		self::assertEmpty([1, 2, 3], $set->toArray());
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
}
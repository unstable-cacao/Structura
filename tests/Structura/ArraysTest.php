<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class ArraysTest extends TestCase
{
	public function test_toArray_Array_ReturnTheArray()
	{
		self::assertEquals([1, 2], Arrays::toArray([1, 2]));
	}
	
	public function test_toArray_ICollection_ReturnArray()
	{
		self::assertEquals([1, 2], Arrays::toArray(new Set([1, 2])));
	}
	
	public function test_toArray_Iterable_ReturnArray()
	{
		self::assertEquals([1 => 1, 3 => 3], Arrays::toArray(new ArraysTestHelper_Iterable()));
	}
	
	public function test_toArray_String_ReturnArrayWithString()
	{
		self::assertEquals(['test'], Arrays::toArray('test'));
	}
	
	public function test_asArray_SetsTheDataToItsArray()
	{
		$data = 'test';
		Arrays::asArray($data);
		
		self::assertEquals(['test'], $data);
	}
	
	public function test_first_Empty_ReturnNull()
	{
		self::assertNull(Arrays::first([]));
	}
	
	public function test_first_ReturnFirstValue()
	{
		self::assertEquals('first', Arrays::first(['first', 'second', 'last']));
	}
	
	public function test_last_Empty_ReturnNull()
	{
		self::assertNull(Arrays::last([]));
	}
	
	public function test_last_ReturnLastValue()
	{
		self::assertEquals('last', Arrays::last(['first', 'second', 'last']));
	}
	
	public function test_isNumeric_Empty_ReturnTrue()
	{
		self::assertTrue(Arrays::isNumeric([]));
	}
	
	public function test_isNumeric_Numeric_ReturnTrue()
	{
		self::assertTrue(Arrays::isNumeric([1, 2, 3, 4]));
	}
	
	public function test_isNumeric_Assoc_ReturnFalse()
	{
		self::assertFalse(Arrays::isNumeric([1 => 1, 2 => 2, 3 => 3, 4 => 4]));
	}
	
	public function test_isAssoc_Empty_ReturnTrue()
	{
		self::assertTrue(Arrays::isAssoc([]));
	}
	
	public function test_isAssoc_Numeric_ReturnFalse()
	{
		self::assertFalse(Arrays::isAssoc([1, 2, 3, 4]));
	}
	
	public function test_isAssoc_Assoc_ReturnTrue()
	{
		self::assertTrue(Arrays::isAssoc([1 => 1, 2 => 2, 'test', 'key' => 'value']));
	}
	
	public function test_firstKey_Empty_ReturnNull()
	{
		self::assertNull(Arrays::firstKey([]));
	}
	
	public function test_firstKey_ReturnFirstKey()
	{
		self::assertEquals('first', Arrays::firstKey(['first' => 1, 'second', 'last']));
	}
	
	public function test_lastKey_Empty_ReturnNull()
	{
		self::assertNull(Arrays::lastKey([]));
	}
	
	public function test_lastKey_ReturnLastKey()
	{
		self::assertEquals(0, Arrays::lastKey([1 => 'first', 2 => 'second', 0 => 'last']));
	}
	
	public function test_mergeRecursiveAssoc_EmptyArrays_ReturnEmptyArray()
	{
		self::assertEquals([], Arrays::mergeRecursiveAssoc([], []));
	}
	
	public function test_mergeRecursiveAssoc_NoIntersection_ReturnMerged()
	{
		self::assertEquals([
			'a' => 1,
			'b' => 2,
			'c' => 3, 
			'd' => 4
		], Arrays::mergeRecursiveAssoc(['a' => 1], ['b' => 2], ['c' => 3, 'd' => 4]));
	}
	
	public function test_mergeRecursiveAssoc_SameKey_NotOverwrites()
	{
		self::assertEquals([
			'a' => 1,
			'b' => 2,
			'c' => 4
		], Arrays::mergeRecursiveAssoc(['a' => 1, 'b' => 2], ['b' => 3, 'c' => 4]));
	}
	
	public function test_mergeRecursiveAssoc_MultiDimentionalArray_Recursive()
	{
		self::assertEquals([
			'a' => 1,
			'b' => [
				'test' 	=> 'hello',
				'test2' => [
					'c' => 3
				]
			]
		], Arrays::mergeRecursiveAssoc(['a' => 1], ['b' => ['test' => 'hello', 'test2' => ['c' => 3]]]));
	}
}


class ArraysTestHelper_Iterable implements \IteratorAggregate
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
		return new \ArrayIterator([1 => 1, 3 => 3]);
	}
}
<?php
namespace Structura;


use PHPUnit\Framework\TestCase;
use Structura\Exceptions\StructuraException;


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
	
	public function test_map_EmptyArray_ReturnEmptyArray()
	{
		self::assertEquals([], Arrays::map([], 'test'));
	}
	
	public function test_map_ArraysArray_ReturnMappedArray()
	{
		$testValue = [
			[
				'id'	=> 'test1',
				'value'	=> 'Test 1'
			],
			[
				'id'	=> 'test2',
				'value'	=> 'Test 2'
			]
		];
		
		$expected = [
			'test1'	=> [
				'id'	=> 'test1',
				'value'	=> 'Test 1'
			],
			'test2'	=> [
				'id'	=> 'test2',
				'value'	=> 'Test 2'
			]
		];
		
		self::assertEquals($expected, Arrays::map($testValue, 'id'));
	}
	
	public function test_map_ObjectsArray_ReturnMappedArray()
	{
		$testValue = [
			(object) [
				'id'	=> 'test1',
				'value'	=> 'Test 1'
			],
			(object) [
				'id'	=> 'test2',
				'value'	=> 'Test 2'
			]
		];
		
		$expected = [
			'test1'	=> (object) [
				'id'	=> 'test1',
				'value'	=> 'Test 1'
			],
			'test2'	=> (object) [
				'id'	=> 'test2',
				'value'	=> 'Test 2'
			]
		];
		
		self::assertEquals($expected, Arrays::map($testValue, 'id'));
	}
	
	public function test_map_ScalarArray_ExpectException()
	{
		self::expectException(StructuraException::class);
		self::expectExceptionMessage('Item not array and not object');
		
		Arrays::map(['test1', 'test2'], 'id');
	}
	
	public function test_map_MixedArray_ExpectException()
	{
		self::expectException(StructuraException::class);
		self::expectExceptionMessage('Item not array and not object');
		
		
		$testValue = [
			[
				'id'	=> 'test1',
				'value'	=> 'Test 1'
			],
			'Test 2'
		];
		Arrays::map($testValue, 'id');
	}
	
	public function test_map_ArraysArray_MissingColumn_ExpectException()
	{
		$testValue = [
			[
				'id'	=> 'test1',
				'value'	=> 'Test 1'
			],
			[
				'value'	=> 'Test 2'
			]
		];
		
		self::expectException(StructuraException::class);
		self::expectExceptionMessage('Column not set');		
		Arrays::map($testValue, 'id');
	}
	
	public function test_map_ObjectsArray_MissingColumn_ExpectException()
	{
		$testValue = [
			(object) [
				'id'	=> 'test1',
				'value'	=> 'Test 1'
			],
			(object) [
				'value'	=> 'Test 2'
			]
		];
		
		self::expectException(StructuraException::class);
		self::expectExceptionMessage('Column not set');
		
		Arrays::map($testValue, 'id');
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
	
	public function test_mergeRecursiveAssoc_MainNotAssoc_ReturnMainAsIs()
	{
		self::assertEquals([
			1
		], Arrays::mergeRecursiveAssoc([1], ['b' => 2]));
	}
	
	public function test_mergeRecursiveAssoc_OneOfInputNotAssoc_MergedOnlyAssoc()
	{
		self::assertEquals([
			'a' => 1,
			'b' => 2,
			'c' => [5]
		], Arrays::mergeRecursiveAssoc(['a' => 1], ['b' => 2, 'c' => [5]], [3]));
	}
	
	public function test_toArrayRecursive()
	{
		self::assertEquals([
			[
				[
					'a' => 1,
					'b' => 2
				],
				5
			],
			"Test"
		], Arrays::toArrayRecursive(new ArraysTestHelper_IterableForRecursion2()));
	}
	
	
	
	
	public function test_merge_SingleArray_ReturnArray(): void
	{
		self::assertEquals(['a'], Arrays::merge(['a']));
	}
	
	public function test_merge_EmptyArrays_ReturnEmptyArray(): void
	{
		self::assertEquals([], Arrays::merge([], [], []));
	}
	
	public function test_merge_NonArrayElement_ReturnElementAsArray(): void
	{
		self::assertEquals(['a'], Arrays::merge('a'));
	}
	
	public function test_merge_NonArrayElements_ReturnArrayWithElements(): void
	{
		self::assertEquals(['a', 'b'], Arrays::merge('a', 'b'));
	}
	
	public function test_merge_Arrays_MergeAllArrays(): void
	{
		self::assertEquals(['a', 'b', 1, 2], Arrays::merge(['a'], ['b'], [1, 2]));
	}
	
	public function test_merge_ArraysAndElements_MergeEverything(): void
	{
		self::assertEquals(['a', 'b', 1, 2, 3], Arrays::merge(['a'], 'b', [1, 2], 3));
	}
	
	public function test_merge_NoParams_ReturnEmptyArray(): void
	{
		self::assertEquals([], Arrays::merge());
	}
	
	public function test_merge_Iterable_TreatIterableAsSingleItem(): void
	{
		$a = new Set([]);
		
		self::assertSame(['a', $a], Arrays::merge('a', $a));
	}
	
	public function test_merge_SingleArrayWithKey_ReturnArray(): void
	{
		self::assertEquals(['a' => 1], Arrays::merge(['a' => 1]));
	}
	
	public function test_merge_ArraysAssoc_MergeAllArrays(): void
	{
		self::assertEquals(['color' => 'green', 2, 4, 'a', 'b', 'shape' => 'trapezoid', 4], 
			Arrays::merge(["color" => "red", 2, 4], ["a", "b", "color" => "green", "shape" => "trapezoid", 4]));
	}
	
	public function test_merge_ArraysAndElementsAssoc_MergeEverything(): void
	{
		self::assertEquals(['key' => 1, 'b', 2, 3], 
			Arrays::merge(['key' => 'a'], 'b', ['key' => 1, 2], 3));
	}
	
	public function test_unique_ReturnUnique(): void
	{
		self::assertEquals([1, 2, 5, 4], Arrays::unique([1, 1, 2, 5, 4, 5, 1]));
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

class ArraysTestHelper_IterableForRecursion implements \IteratorAggregate
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
		return new \ArrayIterator([
			'a' => 1,
			'b' => 2
		]);
	}
}

class ArraysTestHelper_IterableForRecursion2 implements \IteratorAggregate
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
		return new \ArrayIterator([
			[
				new ArraysTestHelper_IterableForRecursion(),
				5
			],
			"Test"
		]);
	}
}
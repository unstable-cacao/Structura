<?php
namespace Structura\Traversal;


use PHPUnit\Framework\TestCase;


class UnitTestTraverserHelper implements ITraverser
{
	public function getElementType(): string {}
	public function travers(array $elements): bool {}
}


class GenericTraversersSetTest extends TestCase
{
	public function test_sanity_NoTraversersSet_ReturnEmptyArray(): void
	{
		$s = new GenericTraversersSet();
		self::assertEmpty($s->getTraversers());
	}
	
	
	public function test_add_SetInstance_InstanceReturned(): void
	{
		$set = new GenericTraversersSet();
		$n = new class extends UnitTestTraverserHelper {};
		
		$set->add($n);
		
		self::assertEquals([$n], $set->getTraversers());
	}
	
	public function test_add_SetClassName_InstanceReturned(): void
	{
		$set = new GenericTraversersSet();
		$n = new class extends UnitTestTraverserHelper {};
		
		$set->add(get_class($n));
		
		self::assertInstanceOf(get_class($n), $set->getTraversers()[0]);
		self::assertCount(1, $set->getTraversers());
	}
	
	public function test_add_ArrayPassed_AllElementsPresent(): void
	{
		$set = new GenericTraversersSet();
		$n = new class extends UnitTestTraverserHelper {};
		
		$set->add([$n, get_class($n)]);
		
		self::assertInstanceOf(get_class($n), $set->getTraversers()[1]);
		self::assertSame($n, $set->getTraversers()[0]);
		self::assertNotSame($n, $set->getTraversers()[1]);
		self::assertCount(2, $set->getTraversers());
	}
	
	public function test_add_TraverserSet_AllElementsPresent(): void
	{
		$set = new GenericTraversersSet();
		$setChild = new GenericTraversersSet();
		
		$n = new class extends UnitTestTraverserHelper {};
		$setChild->add($n);
		
		$set->add($setChild);
		
		self::assertSame([$n], $set->getTraversers());
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_add_InvalidType_ExceptionThrown(): void
	{
		$set = new GenericTraversersSet();
		$set->add($this);
	}
}
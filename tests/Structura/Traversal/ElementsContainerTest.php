<?php
namespace Structura\Traversal;


use PHPUnit\Framework\TestCase;



class UnitTestElementHelper implements ITraversElement
{
	public $id;
	public $compareWith;
	public $compareResult = -1;
	
	public static $mergeA;
	public static $mergeB;
	public static $mergeResult = null;
	
	public static $parseArgs;
	public static $parseResult;
	
	
	public function __construct($id = 'a')
	{
		$this->id = $id;
	}
	
	
	public function id(): string
	{
		return $this->id;
	}
	
	public function compare(ITraversElement $with): int
	{
		$this->compareWith = $with;
		return $this->compareResult;
	}
	
	public static function merge(ITraversElement $a, ITraversElement $b): ITraversElement
	{
		self::$mergeA = $a;
		self::$mergeB = $b;
		
		return self::$mergeResult ?? $a;  
	}
	
	public static function parse(...$args): ITraversElement
	{
		self::$parseArgs = $args;
		return self::$parseResult;
	}
}


class ElementsContainerTest extends TestCase
{
	public function test_addElements_ReturnSelf(): void
	{
		$c = new ElementsContainer();
		self::assertSame($c, $c->addElements(new UnitTestElementHelper()));
	}
	
	
	public function test_addElements_AddSingleItem_ItemReturned(): void
	{
		$e = new UnitTestElementHelper();
		
		$c = new ElementsContainer();
		$c->addElements($e);
		
		self::assertEquals([$e], $c->getTargetElementsForQuery());
	}
	
	public function test_addElements_AddArray_ItemReturned(): void
	{
		$e1 = new UnitTestElementHelper('a');
		$e2 = new UnitTestElementHelper('b');
		
		$c = new ElementsContainer();
		$c->addElements([$e1, $e2]);
		
		self::assertEquals([$e1, $e2], $c->getTargetElementsForQuery());
	}
	
	public function test_addElements_ElementWithSameID_ElementMerged(): void
	{
		$e1 = new UnitTestElementHelper('a');
		$e2 = new UnitTestElementHelper('a');
		$em = new UnitTestElementHelper('a');
		
		UnitTestElementHelper::$mergeResult = $em;
		
		$c = new ElementsContainer();
		$c->addElements([$e1, $e2]);
		
		self::assertSame([$em], $c->getTargetElementsForQuery());
		self::assertTrue(
			($e1 == UnitTestElementHelper::$mergeA && $e2 == UnitTestElementHelper::$mergeB) ||
			($e2 == UnitTestElementHelper::$mergeA && $e1 == UnitTestElementHelper::$mergeB));
	}
	
	public function test_addElements_QueriedElementOfHigherValueExists_ElementNotOveridden(): void
	{
		$e1 = new UnitTestElementHelper('a');
		$e2 = new UnitTestElementHelper('a');
		
		$e1->compareResult = 1;
		$e2->compareResult = -1;
		
		$c = new ElementsContainer();
		$c->addElements([$e1]);
		$c->getTargetElementsForQuery();
		$c->addElements([$e2]);
		
		self::assertEmpty($c->getTargetElementsForQuery());
	}
	
	public function test_addElements_QueriedElementWithSameValue_ElementMergedIntoTarget(): void
	{
		$e1 = new UnitTestElementHelper('a');
		$e2 = new UnitTestElementHelper('a');
		$em = new UnitTestElementHelper('a');
		
		$e1->compareResult = -1;
		$e2->compareResult = 1;
		
		UnitTestElementHelper::$mergeResult = $em;
		
		$c = new ElementsContainer();
		
		$c->addElements([$e1]);
		$c->getTargetElementsForQuery();
		$c->addElements([$e2]);
		
		self::assertSame([$em], $c->getTargetElementsForQuery());
		self::assertTrue(
			($e1 == UnitTestElementHelper::$mergeA && $e2 == UnitTestElementHelper::$mergeB) ||
			($e2 == UnitTestElementHelper::$mergeA && $e1 == UnitTestElementHelper::$mergeB));
	}
	
	
	public function test_getTargetElementsForQuery_NoElements_ReturnEmptyArray(): void
	{
		$c = new ElementsContainer();
		self::assertEmpty($c->getTargetElementsForQuery());
	}
	
	public function test_getTargetElementsForQuery_CalledTwice_ElementsMovedToQueuedList(): void
	{
		$e1 = new UnitTestElementHelper('a');
		
		$c = new ElementsContainer();
		$c->addElements($e1);
		
		$c->getTargetElementsForQuery();
		
		self::assertEmpty($c->getTargetElementsForQuery());
	}
	
	public function test_getTargetElementsForQuery_AddElementAfterCall_OnlyNewElementReturned(): void
	{
		$e1 = new UnitTestElementHelper('a');
		$e2 = new UnitTestElementHelper('b');
		
		$c = new ElementsContainer();
		$c->addElements($e1);
		
		$c->getTargetElementsForQuery();
		$c->addElements($e2);
		
		self::assertSame([$e2], $c->getTargetElementsForQuery());
	}
}
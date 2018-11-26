<?php
namespace Structura;


use PHPUnit\Framework\TestCase;

use Structura\Traversal\AbstractTraversElement;
use Structura\Traversal\ITraverser;
use Structura\Traversal\TraversConfig;
use Structura\Traversal\ITraversElement;


class TraversalTest extends TestCase
{
	public function test_sanity(): void
	{
		$t = new Traversal();
		
		self::assertInstanceOf(TraversConfig::class, $t->config());
		self::assertSame($t, $t->addElement(new TraversalTestElementHelper));
		self::assertSame($t, $t->addElements(new TraversalTestElementHelper));
	}
	
	
	public function test_execute_EmptySet_NoExcpetions(): void
	{
		$s = new Traversal();
		$s->execute();
	}
	
	public function test_execute_MaxPageSize(): void
	{
		$s = new Traversal();
		$t = new TraverserHelper();
		
		$e1 = new TraversalTestElementHelper('a');
		$e2 = new TraversalTestElementHelper('b');
		$e3 = new TraversalTestElementHelper('c');
		$e4 = new TraversalTestElementHelper('d');
		$e5 = new TraversalTestElementHelper('e');
		
		$s->addTraverser($t);
		$s->addElements([$e1, $e2, $e3, $e4, $e5]);
		$s->config()->setMaxPageSize(2); 
		
		
		$s->execute();
		
		
		self::assertSame([[$e1, $e2], [$e3, $e4], [$e5]], $t->calls);
	}
	
	public function test_execute_MaxElements(): void
	{
		$s = new Traversal();
		$t = new TraverserHelper();
		
		$e1 = new TraversalTestElementHelper('a');
		$e2 = new TraversalTestElementHelper('b');
		$e3 = new TraversalTestElementHelper('c');
		$e4 = new TraversalTestElementHelper('d');
		$e5 = new TraversalTestElementHelper('e');
		
		$s->addTraverser($t);
		$s->addElements([$e1, $e2, $e3, $e4, $e5]);
		$s->config()->setMaxPageSize(2); 
		$s->config()->setMaxElements(3); 
		
		
		$s->execute();
		
		
		self::assertSame([[$e1, $e2], [$e3]], $t->calls);
	}
	
	public function test_execute_MaxElementsMatchingPageSize(): void
	{
		$s = new Traversal();
		$t = new TraverserHelper();
		
		$e1 = new TraversalTestElementHelper('a');
		$e2 = new TraversalTestElementHelper('b');
		$e3 = new TraversalTestElementHelper('c');
		$e4 = new TraversalTestElementHelper('d');
		$e5 = new TraversalTestElementHelper('e');
		
		$s->addTraverser($t);
		$s->addElements([$e1, $e2, $e3, $e4, $e5]);
		$s->config()->setMaxPageSize(2); 
		$s->config()->setMaxElements(4); 
		
		
		$s->execute();
		
		
		self::assertSame([[$e1, $e2], [$e3, $e4]], $t->calls);
	}
	
	public function test_execute_TraversalReturnFalse_Abort(): void
	{
		$s = new Traversal();
		$t = new TraverserHelper();
		
		$e1 = new TraversalTestElementHelper('a');
		$e2 = new TraversalTestElementHelper('b');
		$e3 = new TraversalTestElementHelper('c');
		$e4 = new TraversalTestElementHelper('d');
		$e5 = new TraversalTestElementHelper('e');
		
		$t->result = false;
		$s->addTraverser($t);
		$s->addElements([$e1, $e2, $e3, $e4, $e5]);
		$s->config()->setMaxPageSize(2);
		
		
		$s->execute();
		
		
		self::assertSame([[$e1, $e2]], $t->calls);
	}
	
	public function test_execute_AllTravlersalObjectsCalled(): void
	{
		$s = new Traversal();
		
		$t1 = new TraverserHelper();
		$t2 = new TraverserHelper();
		
		$t1->traversCallback = function (array $elements)
			use ($s)
		{
			$s->addElements($elements);
		};
		
		$e1 = new TraversalTestElementHelper('a');
		$e2 = new TraversalTestElementHelper('b');
		
		$s->addTraverser([$t1, $t2]);
		$s->addElements([$e1, $e2]);
		
		
		$s->execute();
		
		
		self::assertSame([[$e1, $e2]], $t1->calls);
		self::assertSame([[$e1, $e2]], $t2->calls);
	}
	
	public function test_execute_MaxIterations(): void
	{
		$s = new Traversal();
		
		$t1 = new TraverserHelper();
		$t2 = new TraverserHelper();
		
		$t1->traversCallback = function (array $elements)
			use ($s)
		{
			$s->addElements($elements);
		};
		$t2->traversCallback = $t1->traversCallback;
		
		$e1 = new TraversalTestElementHelper('a');
		
		$s->addTraverser([$t1, $t2]);
		$s->addElement($e1);
		
		$s->config()->setMaxIterations(5);
		
		
		$s->execute();
		
		
		self::assertSame([[$e1], [$e1], [$e1]], $t1->calls);
		self::assertSame([[$e1], [$e1]], $t2->calls);
	}
	
	public function test_execute_MaxElementsForMultipleTraversals(): void
	{
		$s = new Traversal();
		
		$t1 = new TraverserHelper();
		$t2 = new TraverserHelper();
		
		$t1->traversCallback = function (array $elements)
			use ($s)
		{
			$s->addElements($elements);
		};
		$t2->traversCallback = $t1->traversCallback;
		
		$e1 = new TraversalTestElementHelper('a');
		
		$s->addTraverser([$t1, $t2]);
		$s->addElement($e1);
		
		$s->config()->setMaxElements(5);
		
		
		$s->execute();
		
		
		self::assertSame([[$e1], [$e1], [$e1]], $t1->calls);
		self::assertSame([[$e1], [$e1]], $t2->calls);
	}
	
	
	
	public function test_addElement_AddSingleItem_ItemParsed(): void
	{
		$s = new Traversal();
		$t = new TraverserHelper(); 
		$e = new TraversalTestElementHelper();
		
		$s->addTraverser($t);
		$s->addElement($e);
		
		$s->execute();
		
		
		self::assertSame([[$e]], $t->calls);
	}
	
	public function test_addElement_AddItemByName_ItemParsed(): void
	{
		$s = new Traversal();
		$t = new TraverserHelper(); 
		$e = new TraversalTestElementHelper();
		
		TraversalTestElementHelper::$parseResult = $e;
		
		$s->addTraverser($t);
		$s->addElement(TraversalTestElementHelper::class, 'n', 'f');
		
		
		$s->execute();
		
		
		self::assertSame([[$e]], $t->calls);
		self::assertEquals(['n', 'f'], TraversalTestElementHelper::$parseArgs);
	}
	
	public function test_addElements_AddArrayOfItems_ItemsParsed(): void
	{
		$s = new Traversal();
		$t = new TraverserHelper();
		
		$e1 = new TraversalTestElementHelper('a');
		$e2 = new TraversalTestElementHelper('b');
		
		$s->addTraverser($t);
		$s->addElements([$e1, $e2]);
		
		
		$s->execute();
		
		
		self::assertSame([[$e1, $e2]], $t->calls);
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_addElements_AddArrayWithExtraValues_ExceptionThrown(): void
	{
		$s = new Traversal();
		$s->addElements([], 'a', 'b');
	}
}


class TraverserHelper implements ITraverser
{
	public $element = TraversalTestElementHelper::class;
	public $calls = [];
	public $result = true;
	public $traversCallback = null;
	
	
	public function getElementType(): string
	{
		return $this->element;
	}
	
	/**
	 * @param ITraversElement[] $elements
	 * @return bool
	 */
	public function travers(array $elements): bool
	{
		$this->calls[] = $elements;
		
		if ($this->traversCallback)
		{
			/** @var callable $c */
			$c = $this->traversCallback;
			$c($elements);
		}
			
		return $this->result;
	}
}


class TraversalTestElementHelper extends AbstractTraversElement
{
	public $id;
	public $compareWith;
	public $compareResult = true;
	
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
	
	public function shouldOverrideBy(ITraversElement $with): bool
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
<?php
namespace Structura\Specialized\Map;


use PHPUnit\Framework\TestCase;


class PrefixMapTest extends TestCase
{
	/**
	 * @expectedException \Structura\Exceptions\StructuraException
	 */
	public function test_construct_PrefixNotValid_ExceptionThrown()
	{
		new PrefixMap(0);
	}
	
    public function test_has_PrefixExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
        
        self::assertTrue($subject->has('ClassName'));
    }
    
    public function test_has_PrefixNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->has('ClassName'));
    }
    
    public function test_get_ItemExists_ReturnItem()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertEquals(1, $subject->get('ClassName'));
    }
    
    public function test_get_ItemNotExists_ReturnNull()
    {
        $subject = new PrefixMap();
    
        self::assertNull($subject->get('ClassName'));
    }
    
    public function test_tryGet_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertTrue($subject->tryGet('ClassName', $value));
    }
    
    public function test_tryGet_ItemExists_SetsValue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
        $subject->tryGet('ClassName', $value);
    
        self::assertEquals(1, $value);
    }
    
    public function test_tryGet_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->tryGet('ClassName', $value));
    }
    
    public function test_add_SavesItem()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertTrue($subject->has('ClassName'));
    }
    
    public function test_add_PrefixShorterThanDefined_SavesItem()
    {
        $subject = new PrefixMap();
        $subject->add('Cl', 1);
    
        self::assertTrue($subject->has('Cl'));
    }
    
    public function test_add_PrefixEmpty_SavesItem()
    {
        $subject = new PrefixMap();
        $subject->add('', 1);
    
        self::assertTrue($subject->has(''));
    }
    
    /**
     * @expectedException \Structura\Exceptions\StructuraPrefixMapException
     */
    public function test_add_SubStringsExists_ExceptionThrown()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
        $subject->add('ClassName\Na', 2);
    }
    
    public function test_remove_ItemExists_RemovesItem()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
        $subject->remove('ClassName');
    
        self::assertFalse($subject->has('ClassName'));
    }
    
    public function test_remove_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertTrue($subject->remove('ClassName'));
    }
    
    public function test_remove_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->remove('ClassName'));
    }
    
    public function test_hasFor_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertTrue($subject->hasFor('ClassName'));
    }
    
    public function test_hasFor_SubStringExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertTrue($subject->hasFor('ClassName\Name'));
    }
    
    public function test_hasFor_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
        $subject->add('ClassUnitTests', 1);
    
        self::assertFalse($subject->hasFor('ClassName'));
    }
    
    public function test_find_ItemExists_ReturnItem()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertEquals(1, $subject->find('ClassName\Name'));
    }
	
	public function test_find_ItemExistsWithLongKey_ReturnItem()
	{
		$subject = new PrefixMap();
		$subject->add('ClassName\Name', 1);
		
		self::assertEquals(1, $subject->find('ClassName\Name'));
	}
    
    public function test_find_ItemNotExists_ReturnNull()
    {
        $subject = new PrefixMap();
    
        self::assertNull($subject->find('ClassName\Name'));
    }
    
    public function test_tryFind_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
    
        self::assertTrue($subject->tryFind('ClassName\Name', $value));
    }
    
    public function test_tryFind_ItemExists_SetsValue()
    {
        $subject = new PrefixMap();
        $subject->add('ClassName', 1);
        $subject->tryFind('ClassName\Name', $value);
    
        self::assertEquals(1, $value);
    }
    
    public function test_tryFind_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->tryFind('ClassName\Name', $value));
    }
}
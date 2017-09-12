<?php
namespace Structura\Specialized\Map;


use PHPUnit\Framework\TestCase;


class PrefixMapTest extends TestCase
{
    public function test_has_PrefixExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
        
        self::assertTrue($subject->has('Objection'));
    }
    
    public function test_has_PrefixNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->has('Objection'));
    }
    
    public function test_get_ItemExists_ReturnItem()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertEquals(1, $subject->get('Objection'));
    }
    
    public function test_get_ItemNotExists_ReturnNull()
    {
        $subject = new PrefixMap();
    
        self::assertNull($subject->get('Objection'));
    }
    
    public function test_tryGet_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertTrue($subject->tryGet('Objection', $value));
    }
    
    public function test_tryGet_ItemExists_SetsValue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
        $subject->tryGet('Objection', $value);
    
        self::assertEquals(1, $value);
    }
    
    public function test_tryGet_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->tryGet('Objection', $value));
    }
    
    public function test_add_SavesItem()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertTrue($subject->has('Objection'));
    }
    
    public function test_add_PrefixShorterThanDefined_SavesItem()
    {
        $subject = new PrefixMap();
        $subject->add('Ob', 1);
    
        self::assertTrue($subject->has('Ob'));
    }
    
    public function test_add_PrefixEmpty_SavesItem()
    {
        $subject = new PrefixMap();
        $subject->add('', 1);
    
        self::assertTrue($subject->has(''));
    }
    
    public function test_remove_ItemExists_RemovesItem()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
        $subject->remove('Objection');
    
        self::assertFalse($subject->has('Objection'));
    }
    
    public function test_remove_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertTrue($subject->remove('Objection'));
    }
    
    public function test_remove_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->remove('Objection'));
    }
    
    public function test_hasFor_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertTrue($subject->hasFor('Objection'));
    }
    
    public function test_hasFor_SubStringExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertTrue($subject->hasFor('Objection\LiteObject'));
    }
    
    public function test_hasFor_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
        $subject->add('ObjectUnitTests', 1);
    
        self::assertFalse($subject->hasFor('Objection'));
    }
    
    public function test_find_ItemExists_ReturnItem()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertEquals(1, $subject->find('Objection\LiteObject'));
    }
    
    public function test_find_SubStringsExists_ReturnFirstSubstringedItem()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
        $subject->add('Objection\Lite', 2);
    
        self::assertEquals(1, $subject->find('Objection\LiteObject'));
    }
    
    public function test_find_ItemNotExists_ReturnNull()
    {
        $subject = new PrefixMap();
    
        self::assertNull($subject->find('Objection\LiteObject'));
    }
    
    public function test_tryFind_ItemExists_ReturnTrue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
    
        self::assertTrue($subject->tryFind('Objection\LiteObject', $value));
    }
    
    public function test_tryFind_ItemExists_SetsValue()
    {
        $subject = new PrefixMap();
        $subject->add('Objection', 1);
        $subject->tryFind('Objection\LiteObject', $value);
    
        self::assertEquals(1, $value);
    }
    
    public function test_tryFind_ItemNotExists_ReturnFalse()
    {
        $subject = new PrefixMap();
    
        self::assertFalse($subject->tryFind('Objection\LiteObject', $value));
    }
}
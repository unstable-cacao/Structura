<?php
namespace Structura\Cache;


use PHPUnit\Framework\TestCase;


class TimeoutCacheTest extends TestCase
{
    public function test_get_ObjectExistsAndNotTimedOut_ReturnCache()
    {
        $cache = new TimeoutCache(500);
        $cache->put(100);
        
        self::assertEquals(100, $cache->get());
    }
    
    /**
     * @expectedException \Structura\Exceptions\StructuraCallbackNotProvidedException
     */
    public function test_get_NoCacheAndNoGetter_ExceptionThrown()
    {
        $cache = new TimeoutCache(0);
        $cache->put(100);
    
        $cache->get();
    }
    
    public function test_get_CacheTimedOut_ReturnCallbackResult()
    {
        $cache = new TimeoutCache(0, function() {
            return 100;
        });
        $cache->put(100);
    
        self::assertEquals(100, $cache->get());
    }
    
    
    public function test_put_SetsObject()
    {
        $cache = new TimeoutCache(200);
        $cache->put(111);
        
        self::assertEquals(111, $cache->get());
    }
    
    public function test_put_WithTTL_UpdatesTTL()
    {
        $cache = new TimeoutCache(200);
        $cache->put(111, 16);
    
        self::assertEquals(16, $cache->getTtl());
    }
    
    
    public function test_has_CacheNotSet_ReturnFalse()
    {
        $cache = new TimeoutCache();
        
        self::assertFalse($cache->has());
    }
    
    public function test_has_CacheSetAndNotTimedOut_ReturnTrue()
    {
        $cache = new TimeoutCache(15);
        $cache->put(1);
    
        self::assertTrue($cache->has());
    }
    
    public function test_has_CacheSetAndTimedOut_ReturnFalse()
    {
        $cache = new TimeoutCache(0);
        $cache->put(1);
    
        self::assertFalse($cache->has());
    }
    
    
    public function test_clear_ClearsCache()
    {
        $cache = new TimeoutCache();
        $cache->put(1000);
        $cache->clear();
        
        self::assertFalse($cache->has());
    }
}
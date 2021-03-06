<?php

namespace Ilex\Test;

class Test1 extends \PHPUnit_Framework_TestCase
{
    private $path = 'vendor/cache_folder';

    public function testCacheFolder()
    {
        mkdir($this->path, 0777);
        $cache = new \Ilex\Cache\IdiormCache($this->path);
    }

    public function testSave()
    {
        $cache = new \Ilex\Cache\IdiormCache($this->path);

        $this->assertFalse($cache->isHit('key', 'table', 'default'));

        $cache->save('key', 'test value', 'table', 'default');

        $this->assertEquals('test value', $cache->isHit('key', 'table', 'default'));
    }

    public function testSaveExpire()
    {
        $cache = new \Ilex\Cache\IdiormCache($this->path, 1);

        $cache->save('key2', 'test value2', 'table2', 'default');
        sleep(1);
        $this->assertFalse($cache->isHit('key2', 'table2', 'default'));
    }

    public function testClear()
    {
        $cache = new \Ilex\Cache\IdiormCache($this->path);
        $cache->clear('table', 'default');
        $cache->clear('', 'default');
    }

    public function testGenKey()
    {
        $cache = new \Ilex\Cache\IdiormCache($this->path);
        $this->assertEquals('952c7c3c67becfe353618a2298984d3a', $cache->genKey('adfasf', ['sdf', 'sdfdsf'], 'table', 'default'));
    }
}

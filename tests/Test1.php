<?php

namespace Ilex\Test;

class Test1 extends \PHPUnit_Framework_TestCase
{
    private $path = 'cache_folder';

    /**
     * @expectedException Exception
     */
    public function testException()
    {
        $path = 'a/b';
        $cache = new \Ilex\Cache\IdiormCache($path);
    }

    public function testCacheFolder()
    {
        mkdir($this->path, 0777);
        $cache = new \Ilex\Cache\IdiormCache($this->path);
    }

    public function testSave()
    {
        $cache = new \Ilex\Cache\IdiormCache($this->path);

        $this->assertFalse($cache->isMiss('key', 'table', 'default'));

        $cache->save('key', 'test value', 'table', 'default');

        $this->assertEquals('test value', $cache->isMiss('key', 'table', 'default'));
    }

    public function testClear()
    {
        $cache = new \Ilex\Cache\IdiormCache($this->path);
        $cache->clear('table', 'default');
    }

    public function testGenKey()
    {
        $cache = new \Ilex\Cache\IdiormCache($this->path);
        $this->assertEquals('952c7c3c67becfe353618a2298984d3a', $cache->genKey('adfasf', ['sdf', 'sdfdsf'], 'table', 'default'));
    }
}

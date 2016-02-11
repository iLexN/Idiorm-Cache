<?php

namespace Ilex\Cache;

use Ilex\Cache\Interfaces\IdiormCacheInterface;

class IdiormCache implements IdiormCacheInterface
{
    /* @var $pool \Stash\Pool */
    private $pool;

    private $path = '';

    /**
     * @param string $path
     *
     * @throws \Exception
     */
    public function __construct($path)
    {
        $this->path = $path;
        if (!is_writable($path)) {
            throw new \Exception(sprintf('%s is not exist or writable', $path));
        }

        $driver = new Stash\Driver\FileSystem(array());
        $this->pool = new Stash\Pool($driver);
    }

    public function save($cache_key, $value, $table, $connection_name)
    {
        $item = $pool->getItem($this->path.$cache_key);
        $pool->save($item);
    }

    public function isMiss($cache_key, $table, $connection_name)
    {
        $item = $pool->getItem($this->path.$cache_key);
        if ($item->isMiss()) {
            return false;
        }

        return $item->get();
    }

    public function clear($table, $connection_name)
    {
        $pool->deleteItem($this->path.$connection_name.'/'.$table);
    }

    public function genKey($query, $parameters, $table, $connection_name) {
        $parameter_string = implode(',', $parameters);
        $key = $query.':'.$parameter_string.'-'.$table.'-'.$connection_name;
        
        return $connection_name . '/' . $table . '/' . $key;
    }
}

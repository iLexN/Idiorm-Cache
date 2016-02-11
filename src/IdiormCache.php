<?php

namespace Ilex\Cache;

use Ilex\Cache\Interfaces\IdiormCacheInterface;

class IdiormCache implements IdiormCacheInterface
{
    /* @var $pool \Stash\Pool */
    private $pool;

    /**
     * @param string $path
     *
     * @throws \Exception
     */
    public function __construct($path)
    {
        if (!is_writable($path)) {
            throw new \Exception(sprintf('%s is not exist or writable', $path));
        }
        $options = array('path' => $path);
        $driver = new \Stash\Driver\FileSystem($options);
        $this->pool = new \Stash\Pool($driver);
    }

    public function save($cache_key, $value, $table, $connection_name)
    {
        $item = $this->pool->getItem($connection_name.'/'.$table.'/'.$cache_key);
        $item->lock();
        $this->pool->save($item->set($value));
    }

    public function isMiss($cache_key, $table, $connection_name)
    {
        $item = $this->pool->getItem($connection_name.'/'.$table.'/'.$cache_key);
        if ($item->isMiss()) {
            return false;
        }

        return $item->get();
    }

    public function clear($table, $connection_name)
    {
        $this->pool->deleteItem($connection_name.'/'.$table);
    }

    public function genKey($query, $parameters, $table, $connection_name)
    {
        $parameter_string = implode(',', $parameters);
        $key = $query.':'.$parameter_string.'-'.$table.'-'.$connection_name;

        return hash('md5', $key);
    }
}

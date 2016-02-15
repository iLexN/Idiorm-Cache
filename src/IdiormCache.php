<?php

namespace Ilex\Cache;

use Ilex\Cache\Interfaces\IdiormCacheInterface;

class IdiormCache implements IdiormCacheInterface
{
    /* @var $pool \Stash\Pool */
    private $pool;

    /**
     * expires after in sec, default 1hour = 3600s
     * @var int
     */
    private $expiresAfter;

    /**
     * @param string $path
     *
     * @throws \Exception
     */
    public function __construct($path,$expiresAfter=3600)
    {
        if (!is_writable($path)) {
            throw new \Exception(sprintf('%s is not exist or writable', $path));
        }
        $options = ['path' => $path];
        $driver = new \Stash\Driver\FileSystem($options);
        $this->pool = new \Stash\Pool($driver);

        $this->expiresAfter = $expiresAfter;
    }

    public function save($cache_key, $value, $table, $connection_name)
    {
        $item = $this->pool->getItem($connection_name.'/'.$table.'/'.$cache_key);
        $item->lock();
        $item->expiresAfter($this->expiresAfter);
        $this->pool->save($item->set($value));
    }

    public function isHit($cache_key, $table, $connection_name)
    {
        $item = $this->pool->getItem($connection_name.'/'.$table.'/'.$cache_key);
        if (!$item->isHit()) {
            return false;
        }

        return $item->get();
    }

    public function clear($table, $connection_name)
    {
        if ($table == '') {
            $this->pool->deleteItem($connection_name.'/*');
        } else {
            $this->pool->deleteItem($connection_name.'/'.$table.'/*');
        }
    }

    public function genKey($query, $parameters, $table, $connection_name)
    {
        $parameter_string = implode(',', $parameters);
        $key = $query.':'.$parameter_string.'-'.$table.'-'.$connection_name;

        return hash('md5', $key);
    }
}

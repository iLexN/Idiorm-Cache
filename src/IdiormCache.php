<?php

namespace Ilex\Cache;

class IdiormCache
{
    private $path = '';
    private $prefix = 'idiorm-cache-';
    private $fileExtension = '.cache';

    /**
     * @param string $path   cache File path
     * @param string $prefix cache File name prefix
     *
     * @throws \Exception
     */
    public function __construct($path, $prefix)
    {
        $this->path = $path;
        $this->prefix = $prefix;

        if (!is_writable($path)) {
            throw new \Exception(sprintf('%s is not exist or writable', $path));
        }
    }

    /**
     * wirte the result to cache File.
     *
     * @param string $cache_key
     * @param array  $value           result set
     * @param string $table           db table
     * @param string $connection_name
     */
    public function write($cache_key, $value, $table, $connection_name)
    {
        $folder = $this->getFolder($table, $connection_name);
        if (!$this->checkFolder($folder)) {
            $this->createFolder($folder);
        }
        file_put_contents($folder.$this->getFile($cache_key), json_encode($value));
    }

    /**
     * clear the cache File
     * ORM::clear_cache(); / ORM::configure('caching_auto_clear', true);.
     *
     * @param string $table
     * @param string $connection_name
     */
    public function clear($table, $connection_name)
    {
        if ($table == '') {
            array_map(array($this, 'deleteCacheFile'), glob($this->path.'*', GLOB_ONLYDIR));
        } else {
            $this->deleteCacheFile($this->getFolder($table, $connection_name));
        }
    }

    /**
     * delete carch File.
     *
     * @param string $folder
     */
    private function deleteCacheFile($folder)
    {
        $folder = rtrim($folder, '/').'/';
        if (file_exists($folder)) {
            array_map(unlink, glob($folder.'*'.$this->fileExtension));
        }
    }

    /**
     * check file path exist.
     *
     * @param string $path
     *
     * @return bool
     */
    private function checkFolder($path)
    {
        return file_exists($path);
    }

    /**
     * create folder path.
     *
     * @param string $path carch File path
     */
    private function createFolder($path)
    {
        mkdir($path, '0777');
    }

    /**
     * check and return cache result.
     *
     * @param string $cache_key
     * @param string $table
     * @param string $connection_name
     *
     * @return bool|array
     */
    public function checkCache($cache_key, $table, $connection_name)
    {
        if ($this->exist($cache_key, $table, $connection_name)) {
            return $this->read($cache_key, $table, $connection_name);
        } else {
            return false;
        }
    }

    /**
     * check cache exist.
     *
     * @param string $cache_key
     * @param string $table
     * @param string $connection_name
     *
     * @return bool
     */
    public function exist($cache_key, $table, $connection_name)
    {
        $file = $this->getFolder($table, $connection_name).$this->getFile($cache_key);

        return file_exists($file);
    }

    /**
     * return cache restult set.
     *
     * @param string $cache_key
     * @param string $table
     * @param string $connection_name
     *
     * @return array
     */
    public function read($cache_key, $table, $connection_name)
    {
        return  json_decode(file_get_contents($this->getFolder($table, $connection_name).$this->getFile($cache_key)), true);
    }

    /**
     * get cache file folder path.
     *
     * @param string $table
     * @param string $connection_name
     *
     * @return string
     */
    private function getFolder($table, $connection_name)
    {
        return $this->path.$connection_name.'-'.$table.'/';
    }

    /**
     * get cache file name.
     *
     * @param string $cache_key
     *
     * @return string
     */
    private function getFile($cache_key)
    {
        return $cache_key.$this->fileExtension;
    }

    /**
     * get cache key.
     *
     * @param string $query
     * @param array  $parameters
     * @param string $table
     * @param string $connection_name
     *
     * @return string
     */
    public function genKey($query, $parameters, $table, $connection_name)
    {
        $parameter_string = implode(',', $parameters);
        $key = $query.':'.$parameter_string.'-'.$table.'-'.$connection_name;
        return $this->prefix.hash('md5', $key);
    }
}

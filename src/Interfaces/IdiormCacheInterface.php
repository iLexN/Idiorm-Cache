<?php

namespace Ilex\Cache\Interfaces;

/*
 * Caching Interfaces for Idiorm.
 * http://idiorm.readthedocs.org/en/latest/configuration.html#custom-caching
 */

/**
 * @author user
 */
interface IdiormCacheInterface
{
    /**
     * save the result.
     *
     * @param string $cache_key
     * @param array  $value           result set
     * @param string $table           db table
     * @param string $connection_name
     */
    public function save($cache_key, $value, $table, $connection_name);

    /**
     * check and return cache result.
     *
     * @param string $cache_key
     * @param string $table
     * @param string $connection_name
     *
     * @return bool|array
     */
    public function isMiss($cache_key, $table, $connection_name);

    /**
     * clear the cache File
     * ORM::clear_cache(); / ORM::configure('caching_auto_clear', true);.
     *
     * @param string $table
     * @param string $connection_name
     */
    public function clear($table, $connection_name);

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
    public function genKey($query, $parameters, $table, $connection_name);
}

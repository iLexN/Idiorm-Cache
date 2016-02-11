# How to autoload


    require_once '../vendor/autoload.php';

    $dbCache = new \Ilex\Cache\IdiormCache(__DIR__ .'/../cache/db/');
    ORM::configure('cache_query_result', array($dbCache,'save'));
    ORM::configure('check_query_cache', array($dbCache,'isMiss'));
    ORM::configure('clear_cache', array($dbCache,'clear'));
    ORM::configure('create_cache_key',array($dbCache,'genKey') );



need to learn to write test

Idiorm is created by https://github.com/j4mie/idiorm

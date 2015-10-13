# How to autoload


    require_once '../vendor/autoload.php';

    $dbCache = new \Ilex\DB\IdiormCache(__DIR__ .'/../cache/db/', 'db-cache-');
    ORM::configure('cache_query_result', array($dbCache,'write'));
    ORM::configure('check_query_cache', array($dbCache,'checkCache'));
    ORM::configure('clear_cache', array($dbCache,'clear'));
    ORM::configure('create_cache_key',array($dbCache,'genKey') );



need to learn to write test
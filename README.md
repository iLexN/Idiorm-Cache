[![Coverage Status](https://coveralls.io/repos/github/iLexN/Idiorm-Cache/badge.svg?branch=master)](https://coveralls.io/github/iLexN/Idiorm-Cache?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/iLexN/Idiorm-Cache/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/iLexN/Idiorm-Cache/?branch=master)
[![Build Status](https://travis-ci.org/iLexN/Idiorm-Cache.svg?branch=master)](https://travis-ci.org/iLexN/Idiorm-Cache)
[![StyleCI](https://styleci.io/repos/44163582/shield)](https://styleci.io/repos/44163582)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9b916edb-0aa6-4811-a2e3-b9acbb1d4250/mini.png)](https://insight.sensiolabs.com/projects/9b916edb-0aa6-4811-a2e3-b9acbb1d4250)

# How to autoload


    require_once '../vendor/autoload.php';

    $dbCache = new \Ilex\Cache\IdiormCache(__DIR__ .'/../cache/db/');
    ORM::configure('cache_query_result', array($dbCache,'save'));
    ORM::configure('check_query_cache', array($dbCache,'isMiss'));
    ORM::configure('clear_cache', array($dbCache,'clear'));
    ORM::configure('create_cache_key',array($dbCache,'genKey') );



need to learn to write test

Idiorm is created by https://github.com/j4mie/idiorm

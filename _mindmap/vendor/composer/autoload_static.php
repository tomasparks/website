<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84584240e558f44cd69a1bb5eae0c1ce
{
    public static $files = array (
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tmdb\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Component\\OptionsResolver\\' => 34,
            'Symfony\\Component\\EventDispatcher\\' => 34,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
        ),
        'K' => 
        array (
            'Kevinrob\\GuzzleCache\\' => 21,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Cache\\' => 22,
        ),
        'C' => 
        array (
            'Concat\\Http\\Middleware\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tmdb\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-tmdb/api/lib/Tmdb',
        ),
        'Symfony\\Component\\OptionsResolver\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/options-resolver',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Kevinrob\\GuzzleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/kevinrob/guzzle-cache-middleware/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Doctrine\\Common\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/cache/lib/Doctrine/Common/Cache',
        ),
        'Concat\\Http\\Middleware\\' => 
        array (
            0 => __DIR__ . '/..' . '/rtheunissen/guzzle-log-middleware/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'MusicBrainz' => 
            array (
                0 => __DIR__ . '/..' . '/mikealmond/musicbrainz/src',
            ),
            'Moinax\\TvDb' => 
            array (
                0 => __DIR__ . '/..' . '/moinax/tvdb/src',
            ),
        ),
        'G' => 
        array (
            'Guzzle\\Tests' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/tests',
            ),
            'Guzzle' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84584240e558f44cd69a1bb5eae0c1ce::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84584240e558f44cd69a1bb5eae0c1ce::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit84584240e558f44cd69a1bb5eae0c1ce::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}

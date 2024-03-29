<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5e1edbe678eddc84aff6190df7d091be
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Views\\' => 6,
        ),
        'M' => 
        array (
            'Models\\Database\\' => 16,
            'Models\\' => 7,
        ),
        'C' => 
        array (
            'Controller\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Views\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Views',
        ),
        'Models\\Database\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Models/Database',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Models',
        ),
        'Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5e1edbe678eddc84aff6190df7d091be::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5e1edbe678eddc84aff6190df7d091be::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5e1edbe678eddc84aff6190df7d091be::$classMap;

        }, null, ClassLoader::class);
    }
}

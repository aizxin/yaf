<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit16005676004ee29a6c43f239f7a94399
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sof\\Models\\' => 11,
        ),
        'M' => 
        array (
            'Medoo\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sof\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application/models',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit16005676004ee29a6c43f239f7a94399::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit16005676004ee29a6c43f239f7a94399::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit24dd37dc024573dc8de6994ca398b360
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit24dd37dc024573dc8de6994ca398b360::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit24dd37dc024573dc8de6994ca398b360::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit24dd37dc024573dc8de6994ca398b360::$classMap;

        }, null, ClassLoader::class);
    }
}
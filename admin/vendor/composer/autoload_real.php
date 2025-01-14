<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit6db4b174bfbd4b5cefaf3e9a875e1a86
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit6db4b174bfbd4b5cefaf3e9a875e1a86', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit6db4b174bfbd4b5cefaf3e9a875e1a86', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit6db4b174bfbd4b5cefaf3e9a875e1a86::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}

<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitaa73b0ac5410961cceddbcbd81209e7f
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

        spl_autoload_register(array('ComposerAutoloaderInitaa73b0ac5410961cceddbcbd81209e7f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitaa73b0ac5410961cceddbcbd81209e7f', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitaa73b0ac5410961cceddbcbd81209e7f::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
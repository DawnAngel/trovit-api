<?php

/**
 * Main Autoloader PSR-4 class
 *
 * @author Eric Pinto <ericpinto1985@gmail.com>
 */
class Autoloader
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Autoloader\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('Autoloader', 'loadClassLoader'), true, true);
        self::$loader = new \Autoloader\ClassLoader();
        spl_autoload_unregister(array('Autoloader', 'loadClassLoader'));

        $map = require __DIR__ . '/autoload_psr4.php';
        foreach ($map as $namespace => $path) {
            self::$loader->set($namespace, $path);
        }

        self::$loader->register(true);

        return self::$loader;
    }
}

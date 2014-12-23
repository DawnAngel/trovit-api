<?php

namespace Autoloader;

/**
 * ClassLoader implements a PSR-4 class loader
 *
 * @author Eric Pinto <ericpinto1985@gmail.com>
 */
class ClassLoader
{
    private $prefixLengths = array();
    private $prefixDirs    = array();

    public function getPrefixes()
    {
        return $this->prefixDirs;
    }

    /**
     * Registers a set of PSR-4 directories for a given namespace,
     * replacing any others previously set for this namespace.
     *
     * @param string       $prefix The prefix/namespace, with trailing '\\'
     * @param array|string $paths  The PSR-4 base directories
     *
     * @throws \InvalidArgumentException
     */
    public function set($prefix, $paths)
    {
        $length = strlen($prefix);
        if ('\\' !== $prefix[$length - 1]) {
            throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
        }
        $this->prefixLengths[$prefix[0]][$prefix] = $length;
        $this->prefixDirs[$prefix] = (array) $paths;
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }

    /**
     * Unregisters this instance as an autoloader.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Loads the given class or interface.
     *
     * @param  string    $class The name of the class
     * @return bool|null True if loaded, null otherwise
     */
    public function loadClass($class)
    {
        if ($file = $this->findFile($class)) {
            includeFile($file);

            return true;
        }
    }

    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     *
     * @return string|false The path if found, false otherwise
     */
    public function findFile($class)
    {
        // work around for PHP 5.3.0 - 5.3.2 https://bugs.php.net/50731
        if ('\\' == $class[0]) {
            $class = substr($class, 1);
        }

        $file = $this->findFileWithExtension($class, '.php');

        return $file;
    }

    private function findFileWithExtension($class, $ext)
    {
        // PSR-4 lookup
        $logicalPath = strtr($class, '\\', DIRECTORY_SEPARATOR) . $ext;

        $first = $class[0];
        if (isset($this->prefixLengths[$first])) {
            foreach ($this->prefixLengths[$first] as $prefix => $length) {
                if (0 === strpos($class, $prefix)) {
                    foreach ($this->prefixDirs[$prefix] as $dir) {
                        if (file_exists($file = $dir . DIRECTORY_SEPARATOR . substr($logicalPath, $length))) {
                            return $file;
                        }
                    }
                }
            }
        }
    }
}

/**
 * Scope isolated include.
 *
 * Prevents access to $this/self from included files.
 */
function includeFile($file)
{
    include $file;
}

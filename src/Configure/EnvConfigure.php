<?php
/**
 * Copyright (c) David Gallagher (http://github.com/thegallagher)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) David Gallagher (http://github.com/thegallagher)
 * @link      http://github.com/thegallagher/cake-app
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Configure;

use Dotenv\Dotenv;
use Cake\Utility\Text;

/**
 * Read config from .env files or the environment
 *
 * @package App\Configure
 */
class EnvConfigure
{

    /**
     * Names of constants which will be replaced in environment variables
     *
     * @var string[]
     */
    public static $replaceConstants = [
        'DS', 'ROOT', 'APP_DIR', 'APP', 'CONFIG', 'WWW_ROOT', 'TESTS', 'TMP',
        'LOGS', 'CACHE', 'CAKE_CORE_INCLUDE_PATH', 'CORE_PATH', 'CAKE'
    ];

    /**
     * Has a .env file been loaded?
     *
     * @var bool
     */
    protected static $loaded = false;

    /**
     * Read an environment variable.
     *
     * @param string $key The name of the environment variable to read
     * @param mixed $default The default value for the environment variable if it is not found
     *
     * @return string The value of the environment variable or its default value
     * @throws \RuntimeException If an environment variable was not found and it has no default value
     */
    public static function read($key, $default = null)
    {
        if (!self::$loaded) {
            self::load();
        }

        $value = env($key);
        if ($value === null && $default === null) {
            throw new \RuntimeException(sprintf('Environment variable \'%s\' cannot be empty.', $key));
        }
        return self::insertConstants($value === null ? $default : $value);
    }

    /**
     * Load a .env file
     *
     * @param string $path Path to a directory containing a .env file
     *
     * @return bool True on success, false on failure (ie. there is no .env file)
     */
    public static function load($path = CONFIG)
    {
        $dotenv = new Dotenv($path);
        try {
            $dotenv->load();
        } catch (\InvalidArgumentException $e) {
            return false;
        }
        return true;
    }

    /**
     * Insert certain constants in a string
     *
     * Constants should be prefixed and suffixed with two underscores (`__`).
     * Eg. To use the `LOGS` constant, write `__LOGS__` in the environment variable.
     *
     * @param string $str A string to insert constants into
     *
     * @return string `$str` with constant names replaced with constant values
     */
    protected static function insertConstants($str)
    {
        foreach (self::$replaceConstants as $key => $constant) {
            if (is_int($key)) {
                self::$replaceConstants[$constant] = constant($constant);
                unset(self::$replaceConstants[$key]);
            }
        }
        return Text::insert($str, self::$replaceConstants, ['before' => '__', 'after' => '__']);
    }
}

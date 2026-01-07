<?php
/**
 * This file is part of the Rodas\Scaffold library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Rodas\Scaffold
 * @copyright 2026 Marcos Porto <php@marcospor.to>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://marcospor.to/repositories/scaffold
 */

declare(strict_types=1);

namespace Rodas\Scaffold\Layout;

use Rodas\System\Collections\KeyNotFoundException;

use function array_reverse;
use function call_user_func;
use function crc32;
use function is_callable;

abstract class Javascript {

    public const SCRIPT = 'script';
    public const DEPENDENCIES = 'dependencies';
    public const CRC_32 = 'crc';
    protected $scripts = [];
    public static $hashList = [];

    protected function resolveDependencies(array $script, array &$list): void {
        if (isset($script[static::DEPENDENCIES])) {
            $dependencies = $script[static::DEPENDENCIES];
            foreach ($dependencies as $callable) {
                // Check if the script is already in the list, move it to the beginning
                $name = '';
                if (! is_callable($callable, false, $name)) {
                    require_once 'Rodas/System/Collections/KeyNotFoundException.php';
                    throw new KeyNotFoundException($name);
                }
                if (isset($list[$name])) {
                    $dependency = $list[$name];
                    unset($list[$name]);
                    $list = array_reverse($list, true);
                    $list[$name] = $dependency;
                    $list = array_reverse($list, true);
                }

                // Load the script if necessary
                if (! isset($this->scripts[$name])) {
                    $this->loadScript($callable);
                }
                $dependency = $this->scripts[$name];

                // Check if it has dependencies
                $this->resolveDependencies($dependency, $list);

                // Insert the new element at the beginning
                $list = array_reverse($list, true);
                $list[$name] = $dependency;
                $list = array_reverse($list, true);
            }
        }
    }

    protected function loadScript(callable $callable): void {
        $name = '';
        if (is_callable($callable, false, $name)) {
            $this->scripts[$name] = call_user_func($callable);
            if (isset($this->scripts[$name][static::SCRIPT]) &&
                ! isset($this->scripts[$name][static::CRC_32])) {

                $this->scripts[$name][static::CRC_32] = crc32($this->scripts[$name][static::SCRIPT]);
            }
        } else {
            require_once 'System/Collections/KeyNotFoundException.php';
            throw new KeyNotFoundException($name);
        }
    }

    public static function write(...$scripts): string {
        //$parts = array_merge(...$scripts);
        $fingerprint = '';

        // Write the scripts
        foreach ($scripts as &$part) {
            if (! isset($part[static::CRC_32])) {
                $part[static::CRC_32] = crc32($part[static::SCRIPT]);
            }

            // Skip those that are in the list
            if (in_array($part[static::CRC_32], static::$hashList)) {
                continue;
            }

            // Create the list
            $fingerprint .= sprintf('%s08', dechex($part[static::CRC_32]));

            echo $part[static::SCRIPT];
        }

        // Write the fingerprint
        ob_start(); ?>

if ('scripts' in window) {
  window.scripts += '<?= $fingerprint ?>';
} else {
  window.scripts = '<?= $fingerprint ?>';
}

        <?php
        echo ob_get_clean();
        return $fingerprint;
    }

    public static function setFingerprint(string $fingerprint) : void {
        while (strlen($fingerprint) >= 8) {
            $hash = substr($fingerprint, 0, 8);
            static::$hashList[] = hexdec($hash);
            $fingerprint = substr($fingerprint, 8);
        }
    }

    public function __get(string $name) : array {
        $callable_name = null;
        if (! is_callable([static::class, $name], false, $callable_name)) {
            require_once 'Rodas/System/Collections/KeyNotFoundException.php';
            throw new KeyNotFoundException($name);
        }
        // Load the script if necessary
        if (! isset($this->scripts[$callable_name])) {
            $this->loadScript([static::class, $name]);
        }

        // Create the script list
        $scripts[$callable_name] = $this->scripts[$callable_name];

        // Check if it has dependencies
        $this->resolveDependencies($this->scripts[$callable_name], $scripts);

        return $scripts;
    }

}

if (! isset($javascript)) {
    $javascript = [];
}

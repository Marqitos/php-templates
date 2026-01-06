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
  public static $hashs = [];

  protected function resolveDependencies(array $script, array &$list) : void {
    if (isset($script[self::DEPENDENCIES])) {
      $dependencies = $script[self::DEPENDENCIES];
      foreach($dependencies as $callable) {
        // Comprobamos si el script ya está en la lista, lo mueve al principio
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

        // Cargamos el script si es necesario
        if (! isset($this->scripts[$name])) {
          $this->loadScript($callable);
        }
        $dependency = $this->scripts[$name];

        // Comprobamos si tiene dependencias
        $this->resolveDependencies($dependency, $list);

        // Insertamos el nuevo elemento al principio
        $list = array_reverse($list, true);
        $list[$name] = $dependency;
        $list = array_reverse($list, true);
      }
    }
  }

  protected function loadScript(callable $callable) : void {
    $name = '';
    if (is_callable($callable, false, $name)) {
      $this->scripts[$name] = call_user_func($callable);
      if (isset($this->scripts[$name][self::SCRIPT]) &&
          !isset($this->scripts[$name][self::CRC_32])) {
        $this->scripts[$name][self::CRC_32] = crc32($this->scripts[$name][self::SCRIPT]);
      }
    } else {
      require_once 'System/Collections/KeyNotFoundException.php';
      throw new KeyNotFoundException($name);
    }
  }

  public static function write(...$scripts) {
    $parts = array_merge(...$scripts);
    $fingerprint = '';

    // Escribimos los scripts
    foreach ($parts as &$part) {
      if (! isset($part[self::CRC_32])) {
        $part[self::CRC_32] = crc32($part[self::SCRIPT]);
      }

      // Omitimos los que están en la lista
      if (in_array($part[self::CRC_32], self::$hashs)) {
        continue;
      }

      // Creamos la lista
      $fingerprint .= sprintf('%s08', dechex($part[self::CRC_32]));

      echo $part[self::SCRIPT];
    }

    // Escribimos el fingerprint
    ob_start(); ?>

if ('scripts' in window) {
  window.scripts += '<?= $fingerprint ?>';
} else {
  window.scripts = '<?= $fingerprint ?>';
}

    <?php
    echo ob_get_clean();

  }

  public static function setFingerprint(string $fingerprint) : void {
    while (strlen($fingerprint) >= 8) {
      $hash = substr($fingerprint, 0, 8);
      self::$hashs[] = hexdec($hash);
      $fingerprint = substr($fingerprint, 8);
    }
  }

}

if (! isset($javascript)) {
  $javascript = [];
}

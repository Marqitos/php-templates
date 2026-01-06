<?php
/**
 * This file is part of the Rodas\Templates project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2026 Marcos Porto <php@marcospor.to>
 * @license https://opensource.org/license/MIT MIT
 * @link https://marcospor.to/repositories/templates
 */

namespace Rodas\Layout;

use Rodas\Scaffold\Layout\Javascript;
use Rodas\System\Collections\KeyNotFoundException;
use function file_get_contents;
use function is_callable;

require_once 'Rodas/Scaffold/Layout/Javascript.php';

class Token extends Javascript {

  public const JS_GET_TOKEN = 'getToken';
  public const JS_LOGOUT = 'logout';
  public const JS_JWT = 'JWToken';
  public const JS_TOKEN_ERROR = 'TokenError';
  public const JS_TOKEN_EXPIRED_ERROR = 'TokenExpiredError';

  public function __get(string $name) : array {
    $callable_name = null;
    if(!is_callable([self::class, $name], false, $callable_name)) {
      require_once 'Rodas/System/Collections/KeyNotFoundException.php';
      throw new KeyNotFoundException($name);
    }
    // Cargamos el script si es necesario
    if (!isset($this->scripts[$callable_name])) {
      $this->loadScript([self::class, $name]);
    }

    // Creamos la lista de scripts
    $scripts[$callable_name] = $this->scripts[$callable_name];

    // Comprobamos si tiene dependencias
    $this->resolveDependencies($this->scripts[$callable_name], $scripts);

    return $scripts;
  }

  public static function getToken() : array {
     return [
      self::SCRIPT => file_get_contents(__DIR__ . '/getToken.js'),
      self::DEPENDENCIES  => [
        [self::class, self::JS_JWT],
        [self::class, self::JS_TOKEN_EXPIRED_ERROR],
        [self::class, self::JS_TOKEN_ERROR]
      ]
    ];
  }

  public static function logout() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/logout.js')
    ];
  }

  public static function JWToken() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/JWToken.js'),
      self::DEPENDENCIES  => [
        [self::class, self::JS_TOKEN_ERROR]
      ]
    ];
  }

  public static function TokenError() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/TokenError.js'),
    ];
  }

  public static function TokenExpiredError() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/TokenExpiredError.js'),
      self::DEPENDENCIES  => [
        [self::class, self::JS_TOKEN_ERROR]
      ]
    ];
  }

}

$javascript['token'] = new Token();

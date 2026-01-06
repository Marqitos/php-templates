<?php
/**
 * This file is part of the Rodas\System library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Rodas\System
 * @copyright 2026 Marcos Porto <php@marcospor.to>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://marcospor.to/repositories/system
 */

declare(strict_types=1);

namespace Rodas\System\Collections;

use OutOfBoundsException;
use Throwable;
use Rodas\System\HResults;
use Rodas\System\Localization\Resources;

require_once __DIR__ . '/../HResults.php';
require_once __DIR__ . '/../Localization/Resources.php';

/**
  * Excepción que se produce cuando la clave especificada para obtener acceso a un elemento
  * de una colección no coincide con ninguna clave de la colección.
  */
class KeyNotFoundException extends OutOfBoundsException {

    public function __construct($message = Resources::KEY_NOT_FOUND_EXCEPTION_DEFAULT_MESSAGE, $code = HResults::COR_E_DLLNOTFOUND, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}

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

use Rodas\Layout\Token;
use Rodas\Scaffold\Layout\Javascript;
use Rodas\System\Collections\KeyNotFoundException;

use function file_get_contents;
use function ob_start;
use function ob_get_clean;

require_once 'Rodas/Scaffold/Layout/Javascript.php';

class Request extends Javascript {
    // TODO: Add log for try/catch in ob_* functions

    public const JS_CHECK_TOKEN         = 'checkToken';
    public const JS_PERMISSION_ERROR    = 'PermissionError';
    public const JS_REQUEST_AUTH_DELETE = 'requestAuthDelete';
    public const JS_REQUEST_AUTH_GET    = 'requestAuthGet';
    public const JS_REQUEST_AUTH_POST   = 'requestAuthPost';
    public const JS_REQUEST_GET         = 'requestGet';
    public const JS_REQUEST_POST        = 'requestPost';
    public const JS_RENEW_TOKEN         = 'renewToken';
    public const JS_ON_REQUEST_ERROR    = 'onRequestError';

    # Scripts JavaScript
    public static function checkToken() : array {
        require_once __DIR__ . '/token.php';
        return [
            self::SCRIPT => file_get_contents(__DIR__ . '/checkToken.js'),
            self::DEPENDENCIES  => [
                [self::class, self::JS_RENEW_TOKEN],
                [self::class, self::JS_PERMISSION_ERROR],
                [Token::class, Token::JS_TOKEN_ERROR],
                [Token::class, Token::JS_TOKEN_EXPIRED_ERROR]
            ]
        ];
    }

    public static function onRequestError() : array {
        // TODO: Remove SyncfusionNotifications.Message
        return [
            self::SCRIPT => file_get_contents(__DIR__ . '/onRequestError.js')
        ];
    }

    public static function PermissionError() : array {
        return [
            self::SCRIPT => file_get_contents(__DIR__ . '/PermissionError.js')
        ];
    }

    public static function renewToken() : array {
        ob_start();
        include 'renewToken.js.php';
        $script = ob_get_clean();
        require_once __DIR__ . '/token.php';
        return [
            self::SCRIPT => $script,
            self::DEPENDENCIES  => [
                [Token::class, Token::JS_GET_TOKEN]
            ]
        ];
    }

    public static function requestAuthDelete() : array {
        ob_start();
        include 'requestAuthDelete.js.php';
        $script = ob_get_clean();
        require_once __DIR__ . '/token.php';
        return [
            self::SCRIPT => $script,
            self::DEPENDENCIES  => [
                [self::class, self::JS_CHECK_TOKEN],
                [Token::class, Token::JS_GET_TOKEN],
                [Token::class, Token::JS_TOKEN_ERROR]
            ]
        ];
    }

    public static function requestAuthGet() : array {
        ob_start();
        include 'requestAuthGet.js.php';
        $script = ob_get_clean();
        require_once __DIR__ . '/token.php';
        return [
            self::SCRIPT => $script,
            self::DEPENDENCIES  => [
                [self::class, self::JS_CHECK_TOKEN],
                [Token::class, Token::JS_GET_TOKEN],
                [Token::class, Token::JS_TOKEN_ERROR]
            ]
        ];
    }

    public static function requestAuthPost() : array {
        ob_start();
        include 'requestAuthPost.js.php';
        $script = ob_get_clean();
        require_once __DIR__ . '/token.php';
        return [
            self::SCRIPT => $script,
            self::DEPENDENCIES  => [
                [self::class, self::JS_CHECK_TOKEN],
                [Token::class, Token::JS_GET_TOKEN],
                [Token::class, Token::JS_TOKEN_ERROR]
            ]
        ];
    }

    public static function requestGet() : array {
        ob_start();
        include 'requestGet.js.php';
        $script = ob_get_clean();
        return [
            self::SCRIPT => $script
        ];
    }

    public static function requestPost() : array {
        ob_start();
        include 'requestPost.js.php';
        $script = ob_get_clean();
        return [
            self::SCRIPT => $script
        ];
    }
}

$javascript['request'] = new Request();

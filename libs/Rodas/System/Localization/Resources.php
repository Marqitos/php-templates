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

global $lang, $application;

if (! isset($lang) &&
    isset($application) &&

    $localizationPlugin = $application->hasPlugin('localization')) {
    $localizationPlugin->getLocale();
}
if (isset($lang) &&
    $lang instanceof 'Rodas\System\Language') {

    // TODO: Improve file search
    if ($lang->regionCode !== null &&
        file_exists(__DIR__ . DIRECTORY_SEPARATOR . "{$lang->languageCode}-{$lang->regionCode}.php")) {

        require_once __DIR__ . DIRECTORY_SEPARATOR . "{$lang->languageCode}-{$lang->regionCode}.php";
    } elseif (file_exists(__DIR__ . DIRECTORY_SEPARATOR . "{$lang->languageCode}.php")) {

        require_once __DIR__ . DIRECTORY_SEPARATOR . "{$lang->languageCode}.php";
    } elseif (file_exists(__DIR__ . DIRECTORY_SEPARATOR . "{(string)$lang}.php")) {

        require_once __DIR__ . DIRECTORY_SEPARATOR . "{(string)$lang}.php";
    }
} elseif (isset($lang) &&
          is_string($lang)) {

        // FIX: Use regular expression
        $length = strpos($lang, '-');
    if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . "$lang.php")) {

        require_once __DIR__ . DIRECTORY_SEPARATOR . "$lang.php";
    } elseif (isset($lang) &&
              $length !== false &&
              file_exists(__DIR__ . DIRECTORY_SEPARATOR . substr($lang, 0, $length) . '.php')) {
        require_once __DIR__ . DIRECTORY_SEPARATOR . substr($lang, 0, $length) . '.php';
    }
} else {
    require_once 'en.php';
}

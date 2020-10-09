<?php /* This file has been prefixed by <PHP-Prefixer> for "PHP-Prefixer Getting Started" */

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

spl_autoload_register(function($class)
{
    $class = str_replace('PPP\\', '', $class);
    $file = realpath(__DIR__.'/../../../../src/'.strtr($class, '\\', '/').'.php');

    if (file_exists($file)) {
        require $file;
        return true;
    }
});

use PPP\Monolog\Logger;
use PPP\Monolog\Handler\FirePHPHandler;

$logger = new Logger('firephp');
$logger->pushHandler(new FirePHPHandler);

$logger->addDebug('Debug');
$logger->addInfo('Info');
$logger->addWarning('Warning');
$logger->addError('Error');
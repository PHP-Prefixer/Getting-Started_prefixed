<?php /* This file has been prefixed by <PHP-Prefixer> for "PHP-Prefixer Getting Started" */

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/Monolog/TestCase.php';

spl_autoload_register(function($class)
{
    $class = str_replace('PPP\\', '', $class);
    $file = __DIR__.'/../src/'.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});

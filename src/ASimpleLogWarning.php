<?php
/* This file has been prefixed by <PHP-Prefixer> for "PHP-Prefixer Getting Started" */

namespace Acme;

class ASimpleLogWarning
{
    public function logWarn()
    {
        $log = new \PPP\Monolog\Logger('name');
        $log->pushHandler(new \PPP\Monolog\Handler\StreamHandler('app.log', \PPP\Monolog\Logger::WARNING));
        $log->addWarning('Foo');
    }
}

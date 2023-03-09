<?php

namespace App\Services\Logging;

use Illuminate\Log\Logger;
use Monolog\Handler\RotatingFileHandler;

class JsonLogHandler
{
    /**
     * @param Logger $logger
     */
    public function __invoke($logger)
    {
        /** @var RotatingFileHandler $handler */
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new JsonLogFormatter('backend'));
        }
    }
}

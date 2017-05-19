<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tajmahal86\Gcpconnector\Logger\Handler;

use Monolog\Logger;

class System extends Base
{
    protected $logName = 'system.log';
    protected $loggerType = Logger::INFO;
    protected $options;
    protected $exceptionHandler;

    public function __construct($options = [], $logging = null)
    {
        $this->exceptionHandler = new Exception();
        parent::__construct($options, $logging);
    }

    public function write(array $record)
    {
        if (isset($record['context']['is_exception']) && $record['context']['is_exception']) {
            unset($record['context']['is_exception']);
            $this->exceptionHandler->handle($record);
        } else {
            unset($record['context']['is_exception']);
            $record['formatted'] = $this->getFormatter()->format($record);
            parent::write($record);
        }
    }
}

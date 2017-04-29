<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tajmahal86\Gcpconnector\Logger\Handler;

use Monolog\Logger;

class Exception extends Base
{
    /**
     * @var string
     */
    protected $logName = 'exception.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::INFO;
}

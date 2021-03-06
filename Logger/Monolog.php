<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tajmahal86\Gcpconnector\Logger;

use Monolog\Logger;

class Monolog extends Logger
{
    /**
     * Adds a log record.
     *
     * @param int    $level   The logging level
     * @param string $message The log message
     * @param array  $context The log context
     *
     * @return bool Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = [])
    {
        $context['is_exception'] = $message instanceof \Exception;

        return parent::addRecord($level, $message, $context);
    }
}

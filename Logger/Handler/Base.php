<?php

namespace Tajmahal86\Gcpconnector\Logger\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Google\Cloud\Logging\LoggingClient;
use Monolog\Logger;
use Magento\Framework\Config\File\ConfigFilePool;

class Base extends AbstractProcessingHandler
{
    protected $logName = 'debug.log';
    protected $logger;
    protected $loggerType = Logger::DEBUG;
    protected $options;

    public function __construct($options = [], $logging = null)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $reader = $objectManager->create('\Magento\Framework\App\DeploymentConfig\Reader');
        $env = $reader->load(ConfigFilePool::APP_ENV);

        if (isset($env['gcplogging']['projectId'])) {
            $googleProjectId = $env['gcplogging']['projectId'];
        } else {
            $googleProjectId = $this->detectProjectId();
        }

        if (is_null($logging)) {
            $logging = new LoggingClient([
                'projectId' => $googleProjectId,
            ]);
        }
        $this->logger = $logging->logger($this->logName);

        $this->options = array_merge([
            'resource' => [
                'type' => 'global',
            ],
            'severity' => $this->loggerType,
            'labels' => [
                'project_id' => $googleProjectId,
            ],
            'timestamp' => date('Y-m-dTH:i:sZ'),
        ], $options);
    }

    public function detectProjectId()
    {
        return 'project-id';
    }

    public function write(array $record)
    {
        if (!isset($record['formatted']) || 'string' !== gettype($record['formatted'])) {
            throw new \InvalidArgumentException('StackdriverHandler accepts only formatted records as a string');
        }
        $this->logger->write($record['formatted'], $this->options);
    }
}

<?php

namespace Tajmahal86\Gcpconnector\Logger\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Google\Cloud\Logging\LoggingClient;
use Monolog\Logger;

class Base extends AbstractProcessingHandler
{

    protected $logName = 'debug.log';
	protected $logger;
    protected $loggerType = Logger::DEBUG;
	protected $options;
	protected $googleProjectId = 'my-project';

    public function __construct( $options=[], $logging=null )
    {
		$googleProjectId = $this->googleProjectId;
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
	

    public function write(array $record)
    {
		
        if (!isset($record['formatted']) || 'string' !== gettype($record['formatted']))
        {
            throw new \InvalidArgumentException('StackdriverHandler accepts only formatted records as a string');
        }
        $this->logger->write($record['formatted'], $this->options);
		
    }
}

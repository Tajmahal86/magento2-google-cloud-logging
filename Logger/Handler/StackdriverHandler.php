<?php 

namespace Tajmahal86\Gcpconnector\Logger\Handler;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;

class StackdriverHandler extends ErrorLogHandler
{
    /*
     * @var array
     */
    protected $options;
    /**
     * @param string $googleProjectId Google Project Id
     * @param string $logName         The name of the log to write entries to.
     * @param array $options          Configuration options.
     * @param object $logging         Logging Object(for test)
     */
    public function __construct($googleProjectId='$googleProjectId', $logName='global', $options=[], $logging=null)
    {
        if (is_null($logging)) {
            $logging = new LoggingClient([
                'projectId' => $googleProjectId,
            ]);
        }
        $this->logger = $logging->logger($logName);
        // set logger options.
        // see http://googlecloudplatform.github.io/google-cloud-php/#/
        $this->options = array_merge([
            'resource' => [
                'type' => 'global',
            ],
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



// namespace Magento\Framework\Logger\Handler;

// use Magento\Framework\Filesystem\DriverInterface;
// use Monolog\Formatter\LineFormatter;
// use Monolog\Handler\StreamHandler;
// use Monolog\Logger;

// class Base extends StreamHandler
// {
    // /**
     // * @var string
     // */
    // protected $fileName;

    // /**
     // * @var int
     // */
    // protected $loggerType = Logger::DEBUG;

    // /**
     // * @var DriverInterface
     // */
    // protected $filesystem;

    // /**
     // * @param DriverInterface $filesystem
     // * @param string $filePath
     // */
    // public function __construct(
        // DriverInterface $filesystem,
        // $filePath = null
    // ) {
        // $this->filesystem = $filesystem;
        // parent::__construct(
            // $filePath ? $filePath . $this->fileName : BP . $this->fileName,
            // $this->loggerType
        // );
        // $this->setFormatter(new LineFormatter(null, null, true));
    // }

    // /**
     // * @{inheritDoc}
     // *
     // * @param $record array
     // * @return void
     // */
    // public function write(array $record)
    // {
        // $logDir = $this->filesystem->getParentDirectory($this->url);
        // if (!$this->filesystem->isDirectory($logDir)) {
            // $this->filesystem->createDirectory($logDir);
        // }

        // parent::write($record);
    // }
// }

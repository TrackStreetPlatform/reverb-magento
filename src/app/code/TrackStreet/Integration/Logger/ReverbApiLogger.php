<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Logger;

use Monolog\Logger;

/**
 * Class ReverbApiLogger
 * @package TrackStreet\Integration\Logger
 */
class ReverbApiLogger extends Logger
{
    /** @var \Magento\Framework\Filesystem\Driver\File */
    protected $fileDriver;

    /** @var \Magento\Framework\App\Filesystem\DirectoryList */
    protected $directoryList;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    /**
     * ReverbApiLogger constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param string $name
     * @param array $handlers
     * @param array $processors
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        string $name,
        array $handlers = array(),
        array $processors = array()
    )
    {
        $this->logger = $logger;
        $this->directoryList = $directoryList;
        $this->fileDriver = $fileDriver;
        parent::__construct($name, $handlers, $processors);
    }
}
<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Api;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface EntityProcessorInterface
 * @package TrackStreet\Integration\Api
 */
interface EntityProcessorInterface {

    /**
     * @param array|string $ids
     */
    public function execute($ids = []);

    /**
     * @param OutputInterface $output
     * @return mixed
     */
    public function setOutput(OutputInterface $output);

    /**
     * @return OutputInterface
     */
    public function getOutput();

    /**
     * @param $message
     * @return mixed
     */
    public function writeOutput($message);
}
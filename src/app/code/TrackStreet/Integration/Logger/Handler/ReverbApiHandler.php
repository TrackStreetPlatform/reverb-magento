<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;

/**
 * Class ReverbApiHandler
 * @package TrackStreet\Integration\Logger\Handler
 */
class ReverbApiHandler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/reverb-api.log';
}
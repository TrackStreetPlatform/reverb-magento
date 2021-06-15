<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Api;

/**
 * Interface ApiModelInterface
 * @package TrackStreet\Integration\Api
 */
interface ApiModelDataConverterInterface
{
    /**
     * @param $object
     * @return mixed
     */
    public function convert($object);
}
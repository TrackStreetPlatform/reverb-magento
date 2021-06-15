<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Api;

/**
 * Interface UidSaverInterface
 * @package TrackStreet\Integration\Api
 */
interface UidSaverInterface
{
    /**
     * @param $object
     * @param $reverbObject
     * @return mixed
     */
    public function save($object, $reverbObject);
}
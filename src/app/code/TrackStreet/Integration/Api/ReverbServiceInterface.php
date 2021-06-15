<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Api;

/**
 * Interface ReverbServiceInterface
 * @package TrackStreet\Integration\Api
 */
interface ReverbServiceInterface {

    /**
     * @param $action
     * @param $data
     * @return mixed
     */
    public function put($action, $data);

    /**
     * @param $action
     * @return mixed
     */
    public function get($action);

    /**
     * @param $action
     * @param $data
     * @return mixed
     */
    public function post($action, $data);

    /**
     * @param $action
     * @return mixed
     */
    public function delete($action);
}
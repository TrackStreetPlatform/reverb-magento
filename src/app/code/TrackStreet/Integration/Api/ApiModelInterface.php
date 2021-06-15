<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Api;

/**
 * Interface ApiModelInterface
 * @package TrackStreet\Integration\Api
 */
interface ApiModelInterface
{

    /**
     * @return mixed
     */
    public function save();

    /**
     * @param string $id
     * @return mixed
     */
    public function load($id);

    /**
     * @return mixed
     */
    public function delete();


    /**
     * @return string
     */
    public function getActions();

    /**
     * @return mixed
     */
    public function setActions($actions);

    /**
     * @param $key
     * @return mixed
     */
    public function getAction($key);

    /**
     * @return string
     */
    public function getActionEntity();

    /**
     * @return mixed
     */
    public function setActionEntity($actionEntity);

    /**
     * @return string
     */
    public function getIdField();

    /**
     * @return mixed
     */
    public function setIdField($name);

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return mixed
     */
    public function resetErrors();

    /**
     * @return boolean
     */
    public function hasErrors();
}
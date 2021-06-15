<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Model\Converter;
use TrackStreet\Integration\Api\ApiModelDataConverterInterface;

/**
 * Class AbstractApiModelDataConverter
 * @package TrackStreet\Integration\Model\Converter
 */
class AbstractApiModelDataConverter implements ApiModelDataConverterInterface {

    /**
     * @var \TrackStreet\Integration\Helper\Data
     */
    protected $apiHelper;

    /**
     * AbstractApiModelDataConverter constructor.
     * @param \TrackStreet\Integration\Helper\Data $apiHelper
     */
    public function __construct(\TrackStreet\Integration\Helper\Data $apiHelper)
    {
        $this->apiHelper = $apiHelper;
    }

    /**
     * @param $object
     * @return mixed
     */
    public function convert($object)
    {
        return $object->getData();
    }
}
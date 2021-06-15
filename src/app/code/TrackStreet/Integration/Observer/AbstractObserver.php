<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use TrackStreet\Integration\Api\ApiModelDataConverterInterface;
use TrackStreet\Integration\Api\ApiModelInterface;
use TrackStreet\Integration\Api\UidSaverInterface;
/**
 * Class AbstractObserver
 * @package TrackStreet\Integration\Observer\Order
 */
abstract class AbstractObserver implements ObserverInterface
{
    /**
     * @var ApiModelInterface
     */
    protected $apiModel;

    /**
     * @var \TrackStreet\Core\Helper\Data
     */
    protected $coreHelper;

    /**
     * @var ApiModelDataConverterInterface
     */
    protected $dataConverter;

    /**
     * @var UidSaverInterface
     */
    protected $uidSaver;

    /**
     * Save constructor.
     * @param \TrackStreet\Core\Helper\Data $coreHelper
     * @param ApiModelInterface $apiModel
     * @param ApiModelDataConverterInterface $apiModelDataConverter
     */
    public function __construct(
        \TrackStreet\Core\Helper\Data $coreHelper,
        ApiModelInterface $apiModel,
        ApiModelDataConverterInterface $apiModelDataConverter,
        UidSaverInterface $uidSaver
    )
    {
        $this->apiModel = $apiModel;
        $this->coreHelper = $coreHelper;
        $this->dataConverter =  $apiModelDataConverter;
        $this->uidSaver = $uidSaver;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer) {
        if ($this->coreHelper->isEnabled()) {
            $this->executeObserver($observer);
        }
    }

    /**
     * @param Observer $observer
     * @return mixed
     */
    abstract function executeObserver(Observer $observer);
}
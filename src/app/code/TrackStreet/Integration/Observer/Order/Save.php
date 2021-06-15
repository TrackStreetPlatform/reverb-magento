<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Observer\Order;

use Magento\Framework\Event\Observer;
use TrackStreet\Integration\Observer\AbstractObserver;

/**
 * Class Save
 * @package TrackStreet\Integration\Customer\Observer
 */
class Save extends AbstractObserver
{

    /**
     * @param Observer $observer
     * @throws \Exception
     */
    public function executeObserver(Observer $observer)
    {
        /**
         * @var $order \Magento\Sales\Model\Order
         */
        $order = $observer->getOrder();
        $reverbOrder = $this->apiModel;

        if($order->getReverbUuid()) {
            $reverbOrder->load($order->getReverbUuid());
            $reverbOrder->addData($this->dataConverter->convert($order));
            $reverbOrder->save();
        }
    }


}
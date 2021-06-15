<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Observer\Order;

use Magento\Framework\Event\Observer;
use TrackStreet\Integration\Observer\AbstractObserver;

/**
 * Class Delete
 * @package TrackStreet\Integration\Customer\Observer
 */
class Delete extends AbstractObserver
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
            $reverbOrder->setUuid($order->getReverbUuid());
            $reverbOrder->delete();
        }
    }
}
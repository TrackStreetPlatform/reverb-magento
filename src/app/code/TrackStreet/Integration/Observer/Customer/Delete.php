<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Observer\Customer;

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
     */
    public function executeObserver(Observer $observer)
    {
        $customer = $observer->getCustomer();
        $reverbCustomer = $this->apiModel->load($customer->getEmail());
        if ($reverbCustomer->getUuid()) {
            $reverbCustomer->delete();
        }
    }
}
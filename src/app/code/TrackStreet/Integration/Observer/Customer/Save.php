<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Observer\Customer;

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
     */
    public function executeObserver(Observer $observer)
    {
        $customer = $observer->getCustomer();
        $customer = $customer->load($customer->getId());
        $reverbCustomer = $this->apiModel->load($customer->getEmail());

        if (!$reverbCustomer->getUuid()) {
            $reverbCustomer->addData($this->dataConverter->convert($customer));
            $reverbCustomer->save();
            $this->uidSaver->save($customer, $reverbCustomer);
            return $this;
        }

        if($reverbCustomer->getUuid() && !$customer->getReverbUuid()) {
            $this->uidSaver->save($customer, $reverbCustomer);
        }

        if ($reverbCustomer->getUuid() && $customer->getReverbUuid()) {
            $reverbCustomer->addData($this->dataConverter->convert($customer));
            $reverbCustomer->save();
        }
    }
}
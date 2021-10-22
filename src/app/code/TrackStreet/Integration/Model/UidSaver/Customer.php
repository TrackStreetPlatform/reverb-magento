<?php

namespace TrackStreet\Integration\Model\UidSaver;

use TrackStreet\Integration\Api\UidSaverInterface;

/**
 * Class Customer
 * @package TrackStreet\Integration\Model\Converter
 */
class Customer implements UidSaverInterface
{

    /**
     * @var \Magento\Customer\Model\ResourceModel\CustomerFactory
     */
    protected $customerFactory;

    /**
     * Customer constructor.
     * @param \Magento\Customer\Model\ResourceModel\CustomerFactory $customerFactory
     */
    public function __construct(
        \Magento\Customer\Model\ResourceModel\CustomerFactory $customerFactory
    )
    {
        $this->customerFactory = $customerFactory;
    }

    /**
     * @param $object
     * @param $reverbObject
     * @return $this|mixed
     */
    public function save($object, $reverbObject)
    {
        if ($reverbObject->getUuid()) 
        {
            $object->setReverbUuid($reverbObject->getUuid());
            $customerResource = $this->customerFactory->create();
            $customerResource->saveAttribute($object, 'reverb_uuid');
            
            return $this;
        }
    }
}
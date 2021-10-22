<?php

/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Model\Converter;

use Amasty\CrossLinks\Helper\Data;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;

/**
 * Class Customer
 * 
 * @package TrackStreet\Integration\Model\Converter
 */
class Order extends AbstractApiModelDataConverter
{
    /**
     * @var \Magento\Catalog\Helper\ImageFactory
     */
    protected $imageHelperFactory;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    protected $appEmulation;

    /**
     * Order constructor.
     * 
     * @param \TrackStreet\Integration\Helper\Data $apiHelper
     * @param \Magento\Store\Model\App\Emulation $appEmulation
     * @param \Magento\Catalog\Helper\ImageFactory $imageFactory
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     */
    public function __construct(
        \TrackStreet\Integration\Helper\Data $apiHelper,
        \Magento\Store\Model\App\Emulation $appEmulation,
        \Magento\Catalog\Helper\ImageFactory $imageFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        parent::__construct($apiHelper);
        $this->imageHelperFactory = $imageFactory;
        $this->customerFactory = $customerFactory;
        $this->appEmulation = $appEmulation;
    }

    /**
     * @param $object \Magento\Sales\Model\Order
     * @return array|mixed
     */
    public function convert($object)
    {
        $reverbOrderData = [
            'website_uuid' => $this->apiHelper->getWebsiteUuid(),
            'order_number' => $object->getIncrementId(),
            'subtotal' => $object->getSubtotal()
        ];

        $reverbOrderData = array_merge($object->getData(),$reverbOrderData);

        if ($object->getReverbUuid()) 
        {
            $reverbOrderData['uuid'] = $object->getReverbUuid();
        }

        $reverbOrderData['coupon_used'] = $object->getCouponCode() ? $object->getCouponCode() : '';
        
        $reverbOrderItems = [];

        foreach ($object->getAllVisibleItems() as $item) 
        {
            $reverbOrderItem = array_merge(
                $item->getData(),
                [
                    'product_id' => $item->getSku(),
                    'price' => $item->getPrice(),
                    'quantity' => $item->getQtyOrdered(),
                    'product_title' => $item->getName(),
                    'product_url' => $item->getProduct()->getProductUrl(),
                    'product_image_url' => $this->getImageUrl($item->getProduct()),
                ]
            );

            $reverbOrderItems[] = $reverbOrderItem;
        }

        $reverbOrderData['order_items'] = $reverbOrderItems;

        $reverbOrderData['customer_uuid'] = $this->getCustomerUuid($object);
        
        return $reverbOrderData;
    }

    /**
     * @param $product
     * @return string
     */
    protected function getImageUrl($product)
    {
        $this->appEmulation->startEnvironmentEmulation(0, \Magento\Framework\App\Area::AREA_FRONTEND, TRUE);

        $url =  $this->imageHelperFactory->create()->init($product, 'product_thumbnail_image')->getUrl();

        $this->appEmulation->stopEnvironmentEmulation();
        
        return $url;
    }

    /**
     * @param $order \Magento\Sales\Model\Order
     * @return string
     */
    protected function getCustomerUuid($order)
    {
        if (!$order->getCustomerIsGuest()) 
        {
            $customer = $this->customerFactory->create()->load($order->getCustomerId());

            if (!$customer->getData('reverb_uuid')) 
            {
                $customer->save();
            }

            return $customer->getData('reverb_uuid');
        } 
        else 
        {
            $reverbCustomer = $this->getObjectManager()->create('TrackStreet\Integration\Model\Customer');

            $reverbCustomer->load($order->getCustomerEmail());
            
            if (!$reverbCustomer->getUuid()) 
            {
                $dataConverter = $this->getObjectManager()->get('TrackStreet\Integration\Model\Converter\GuestCustomer');

                $reverbCustomer->addData($dataConverter->convert($order))->save();
            }
            
            return $reverbCustomer->getUuid();
        }
    }

    /**
     * @return ObjectManager
     */
    private function getObjectManager()
    {
        return ObjectManager::getInstance();
    }
}

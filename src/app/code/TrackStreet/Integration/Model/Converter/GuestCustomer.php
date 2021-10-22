<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Model\Converter;
/**
 * Class Customer
 * @package TrackStreet\Integration\Model\Converter
 */
class GuestCustomer extends AbstractApiModelDataConverter {

    /**
     * @param $object \Magento\Sales\Model\Order
     * @return array|mixed
     */
    public function convert($object)
    {
        $reverbCustomerData = [
            'website_uuid' => $this->apiHelper->getWebsiteUuid(),
            'email' => $object->getCustomerEmail(),
            'first_name' => $object->getCustomerFirstname(),
            'last_name' => $object->getCustomerLastname(),
            'tax_number' => $object->getCustomerTaxvat(),
            'campaign_uuid' => $this->apiHelper->getCampaignUuid()
        ];

        $address = $object->getShippingAddress();

        if($address && $address->getId()) {
            $reverbCustomerData = array_merge(
                [
                    'phone' => $address->getTelephone(),
                    'fax' => $address->getFax(),
                    'company_name' => $address->getCompany(),
                    'address_line_1' => (count($address->getStreet()) > 0) ? $address->getStreet()[0] : '',
                    'address_line_2' => (count($address->getStreet()) > 1) ? $address->getStreet()[1] : '',
                    'city' => $address->getCity(),
                    'zip' => $address->getPostcode(),
                    'state' => $address->getRegion(),
                ],
                $reverbCustomerData
            );
        }
        return $reverbCustomerData;
    }
}
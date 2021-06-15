<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Model\Converter;
/**
 * Class Customer
 * @package TrackStreet\Integration\Model\Converter
 */
class Customer extends AbstractApiModelDataConverter {

    /**
     * @param $object \Magento\Customer\Model\Customer
     * @return array|mixed
     */
    public function convert($object)
    {
        $reverbCustomerData = [
            'store_uuid' => $this->apiHelper->getStoreUuid(),
            'email' =>  $object->getEmail(),
            'first_name' => $object->getFirstname(),
            'last_name' => $object->getLastname(),
            'tax_number' => $object->getTaxClassId(),
            'program_uuid' => $this->apiHelper->getReferralProgramUuid(),
            'customer_id'=>$object->getId()
        ];

        $address = $object->getDefaultShippingAddress();
        if($address && $address->getId()) {
            $reverbCustomerData = array_merge(
                [
                    'phone'=> $address->getTelephone(),
                    'fax' => $address->getFax(),
                    'company_name'=>$address->getCompany(),
                    'address_line_1'=>(count($address->getStreet())>0) ? $address->getStreet()[0] : '',
                    'address_line_2'=>(count($address->getStreet())>1) ? $address->getStreet()[1] : '',
                    'city'=>$address->getCity(),
                    'zip'=>$address->getPostcode(),
                    'state'=>$address->getRegion(),
                ],
                $reverbCustomerData
            );
        }
        return $reverbCustomerData;
    }
}
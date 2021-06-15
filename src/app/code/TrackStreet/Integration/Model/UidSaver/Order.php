<?php
namespace TrackStreet\Integration\Model\UidSaver;
use TrackStreet\Integration\Api\UidSaverInterface;

/**
 * Class Order
 * @package TrackStreet\Integration\Model\Converter
 */
class Order implements UidSaverInterface {

    /**
     * @param $object \Magento\Customer\Model\Customer
     * @param $reverbObject
     * @return $this|mixed
     */
    public function save($object,$reverbObject) {
        if($reverbObject->getUuid()) {
            $object->getResource()->getConnection()
                ->update(
                    $object->getResource()->getMainTable(),
                    ['reverb_uuid' =>$reverbObject->getUuid()],
                    "entity_id = {$object->getId()}"
                );
            $object->setReverbUuid($reverbObject->getUuid());
        }
        return $this;
    }
}
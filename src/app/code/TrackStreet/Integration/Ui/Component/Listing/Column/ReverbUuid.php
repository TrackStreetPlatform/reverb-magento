<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Integration\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Sales\Model\OrderFactory;

class ReverbUuid extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $orderFactory;
    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderFactory $orderFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->orderFactory = $orderFactory;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $order = $this->orderFactory->create()->load($item['entity_id']);
                $item['reverb_uuid'] = $order->getData('reverb_uuid');
            }
        }
        return $dataSource;
    }
}
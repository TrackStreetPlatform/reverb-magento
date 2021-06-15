<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Success
 * @package TrackStreet\Core\Block
 */
class Success extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \TrackStreet\Core\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;


    /**
     * @var \Magento\Catalog\Helper\ImageFactory
     */
    protected $imageHelperFactory;

    /**
     * Success constructor.
     * @param Template\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \TrackStreet\Core\Helper\Data $helper
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Helper\ImageFactory $imageHelperFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \TrackStreet\Core\Helper\Data $helper,
        StoreManagerInterface $storeManager,
        \Magento\Catalog\Helper\ImageFactory $imageHelperFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_helper = $helper;
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory = $orderFactory;
        $this->imageHelperFactory = $imageHelperFactory;
    }

    /**
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->_orderFactory->create()->load($this->_checkoutSession->getLastOrderId());
    }

    /**
     * @return \TrackStreet\Core\Helper\Data
     */
    public function getSettings() {
        return $this->_helper;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getImageUrl($product){
      return  $this->imageHelperFactory->create()
            ->init($product, 'product_thumbnail_image')->getUrl();
    }
}
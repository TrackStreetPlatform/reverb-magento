<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Block;
use Magento\Framework\View\Element\Template;

/**
 * Class View
 * @package TrackStreet\Core\Block
 */
class View extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \TrackStreet\Core\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \TrackStreet\Core\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \TrackStreet\Core\Helper\Data $helper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_helper = $helper;
        $this->_customerSession = $customerSession;
    }

    /**
     * @return \TrackStreet\Core\Helper\Data
     */
    public function getSettings()
    {
        return $this->_helper;
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }

    /**
     * @return int|null
     */
    public function getCustomerEmail()
    {
        return $this->_customerSession->getCustomer()->getEmail();
    }


}
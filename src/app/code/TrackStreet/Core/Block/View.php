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
     * Get the customer's email address from the logged in customer object with Magento.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->_customerSession->getCustomer()->getEmail();
    }

    /**
     * Get the customer's first name from the logged in customer object with Magento.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->_customerSession->getCustomer()->getFirstname();
    }

    /**
     * Get the customer's last name from the logged in customer object with Magento.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getCustomerLastName()
    {
        return $this->_customerSession->getCustomer()->getLastname();
    }

    /**
     * Get the customer's phone number from the logged in customer object with Magento.
     * 
     * @author Christophe Sautot
     * @return string
     */
    public function getCustomerPhoneNumber()
    {
        return $this->_customerSession->getCustomer()->getTelephone();
    }
}
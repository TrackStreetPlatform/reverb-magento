<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Block\Adminhtml;

/**
 * Class Iframe
 * @package TrackStreet\Core\Block\Adminhtml
 */
class Iframe extends \Magento\Backend\Block\Template {

    /**
     * @var \TrackStreet\Core\Helper\Data
     */
    protected $_helper;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \TrackStreet\Core\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \TrackStreet\Core\Helper\Data $helper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_helper = $helper;
    }

    /**
     * @return \TrackStreet\Core\Helper\Data
     */
    public function getSettings()
    {
        return $this->_helper;
    }
}
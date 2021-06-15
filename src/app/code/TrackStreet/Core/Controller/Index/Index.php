<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Controller\Index;

/**
 * Class Index
 * @package TrackStreet\Core\Controller\Advocates
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        return parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $this->resultPage = $this->resultPageFactory->create();
        return $this->resultPage;
    }

}
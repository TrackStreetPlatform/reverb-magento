<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Controller\Adminhtml\Reverb;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package TrackStreet\Core\Controller\Adminhtml\Reverb
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'TrackStreet_Core::dashboard';

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page\Interceptor $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend("TrackStreet Reverb");
        $resultPage->getConfig()->getTitle()->prepend("Dashboard");
        return $resultPage;
    }
}
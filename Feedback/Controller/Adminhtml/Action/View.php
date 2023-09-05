<?php

namespace Tasks\Feedback\Controller\Adminhtml\Action;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Backend\App\Action;

class View extends Action
{
    /** @var PageFactory */
    private $pageFactory;
    public function __construct(
        Context $context,
        PageFactory $rawFactory
    ) {
        $this->pageFactory = $rawFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('View Feedback'));
        return $resultPage;
    }
}

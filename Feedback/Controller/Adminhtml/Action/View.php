<?php

namespace Tasks\Feedback\Controller\Adminhtml\Action;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

/**
 * Adminhtml View Feedback Action Controller
 *
 * @package Tasks\Feedback\Controller\Adminhtml\Action
 */
class View extends Action
{
    /** @var PageFactory */
    private $pageFactory;

    /**
     * View constructor.
     *
     * @param Context $context
     * @param PageFactory $rawFactory
     */
    public function __construct(
        Context $context,
        PageFactory $rawFactory
    ) {
        $this->pageFactory = $rawFactory;
        parent::__construct($context);
    }

    /**
     * Execute action to display the feedback view page
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('View Feedback'));
        return $resultPage;
    }
}

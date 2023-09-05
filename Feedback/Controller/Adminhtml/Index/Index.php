<?php
/**
 * Tasks Feedback Adminhtml Index Controller
 *
 * @package Tasks\Feedback\Controller\Adminhtml\Index
 */

namespace Tasks\Feedback\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;

/**
 * Index Action Controller
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action to display the adminhtml index page
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Posts')));
        return $resultPage;
    }
}

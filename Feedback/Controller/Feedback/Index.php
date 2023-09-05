<?php
namespace Tasks\Feedback\Controller\Feedback;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
class Index extends Action
{
    protected $customerSession;
    public function __construct(
        Context $context,
        Session $customerSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
    }
    public function execute()
    {
        if ($this->customerSession->isLoggedIn()) {
            // User is logged in, show feedback form
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        } else {
            // User is not logged in, show login link and basic form
            $this->_redirect('feedback/feedback/indexwithlogin');
        }
    }
}

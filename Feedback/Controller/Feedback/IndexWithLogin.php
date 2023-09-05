<?php

namespace Tasks\Feedback\Controller\Feedback;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

/**
 * Feedback IndexWithLogin Action Controller
 *
 * @package Tasks\Feedback\Controller\Feedback
 */
class IndexWithLogin extends Action
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * IndexWithLogin constructor.
     *
     * @param Context $context
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        Session $customerSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
    }

    /**
     * Execute action to redirect to feedback form or display login link and basic form
     */
    public function execute()
    {
        if ($this->customerSession->isLoggedIn()) {
            // User is logged in, redirect to the feedback form
            $this->_redirect('feedback/feedback');
        } else {
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        }
    }
}

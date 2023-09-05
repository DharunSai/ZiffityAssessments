<?php

namespace Tasks\Feedback\Controller\Adminhtml\Mail;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Tasks\Feedback\Helper\Mail;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\Http;
use Tasks\Feedback\Model\Feedback;
class Accept extends Action
{
    /** @var PageFactory */
    private $pageFactory;
    protected $request;
    protected $_helperMail;
    protected $feedbackModel;
    public function __construct(
        Context $context,
        PageFactory $rawFactory,
        Mail $helperMail,
        Http $request,
        Feedback $feedbackModel,
    ) {
        $this->pageFactory = $rawFactory;
        $this->_helperMail = $helperMail;
        $this->request = $request;
        $this->feedbackModel = $feedbackModel;
        parent::__construct($context);
    }
    public function execute()
    {
        $email = $this->request->getParam('email');
        $this->feedbackModel->markAsAccepted($email);
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Feedback'));
        $this->_helperMail->sendEmail($email,'email_accept_template');
        return $resultPage;
    }
}

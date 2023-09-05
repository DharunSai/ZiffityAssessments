<?php

namespace Tasks\Feedback\Controller\Adminhtml\Mail;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Tasks\Feedback\Helper\Mail;
use Magento\Framework\App\Request\Http;
use Tasks\Feedback\Model\Feedback;

/**
 * Adminhtml Reject Mail Action Controller
 *
 * @package Tasks\Feedback\Controller\Adminhtml\Mail
 */
class Reject extends Action
{
    /** @var PageFactory */
    private $pageFactory;

    /** @var Http */
    protected $request;

    /** @var Mail */
    protected $_helperMail;

    /** @var Feedback */
    protected $feedbackModel;

    /**
     * Reject constructor.
     *
     * @param Context $context
     * @param PageFactory $rawFactory
     * @param Mail $helperMail
     * @param Http $request
     * @param Feedback $feedbackModel
     */
    public function __construct(
        Context $context,
        PageFactory $rawFactory,
        Mail $helperMail,
        Http $request,
        Feedback $feedbackModel
    ) {
        $this->pageFactory = $rawFactory;
        $this->_helperMail = $helperMail;
        $this->request = $request;
        $this->feedbackModel = $feedbackModel;
        parent::__construct($context);
    }

    /**
     * Execute action to mark feedback as rejected, send email, and display the result page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $email = $this->request->getParam('email');
        $this->feedbackModel->markAsRejected($email);
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Feedback'));
        $this->_helperMail->sendEmail($email, 'email_reject_template');
        return $resultPage;
    }
}

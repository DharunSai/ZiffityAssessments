<?php

namespace Tasks\Feedback\Controller\Actions;

use Laminas\Feed\Writer\Feed;
use Tasks\Feedback\Model\Feedback;
use Tasks\Feedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

/**
 * Save Feedback Action Controller
 *
 * @package Tasks\Feedback\Controller\Actions
 */
class Save extends Action
{
    /**
     * @var Feedback
     */
    protected $feedback;

    /**
     * @var FeedbackResourceModel
     */
    protected $feedbackResourceModel;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param Feedback $feedback
     * @param FeedbackResourceModel $feedbackResourceModel
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        Feedback $feedback,
        FeedbackResourceModel $feedbackResourceModel,
        Session $customerSession
    ) {
        $this->feedback = $feedback;
        $this->feedbackResourceModel = $feedbackResourceModel;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

     /**
     * This method will access the resource model
     */
    public function accessResourceModel($feed)
    {
        try {
            $this->feedbackResourceModel->save($feed);
            $this->messageManager->addSuccessMessage(__("Successfully added  %1"));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something went wrong."));
        }
        /* Redirect back to hero display page */
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('');
        return $redirect;
    }


    /**
     * This method will save the form data in database
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            $customerFirstName = $customer->getFirstname();
            $customerLastName = $customer->getLastname();
            $customerEmail = $customer->getEmail();
            $CustomerFeedback = $params['feedback'];
            $dataObject = [
                'firstName' => $customerFirstName,
                'lastName' => $customerLastName,
                'email' => $customerEmail,
                'feedback' => $CustomerFeedback
            ];
            $feed = $this->feedback->setData($dataObject);
            $this->accessResourceModel($feed);
        } else {
            $dataObject = [
                'firstName' => $params['first_name'],
                'lastName' => $params['last_name'],
                'email' => $params['email'],
                'feedback' => $params['feedback']
            ];
            $feed = $this->feedback->setData($dataObject);
            $this->accessResourceModel($feed);
        }
    }
}

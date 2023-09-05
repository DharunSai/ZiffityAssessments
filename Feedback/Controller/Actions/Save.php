<?php

namespace Tasks\Feedback\Controller\Actions;


use Laminas\Feed\Writer\Feed;
use Tasks\Feedback\Model\Feedback;
use Tasks\Feedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
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
    protected  $customerSession;
    /**
     * Add constructor.
     * @param Context $context
     * @param Feedback $feedback
     * @param FeedbackResourceModel $feedbackResourceModel
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

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        if ($this->customerSession->isLoggedIn()) {
            // User is logged in, show feedback form
            $customer = $this->customerSession->getCustomer();
            $customerFirstName = $customer->getFirstname();
            $customerLastName = $customer->getLastname();
            $customerEmail = $customer->getEmail();
            $CustomerFeedback = $params['feedback'];
            $dataObject =[
                'firstName'=>$customerFirstName,
                'lastName'=>$customerLastName,
                'email'=>$customerEmail,
                'feedback'=>$CustomerFeedback
            ];
            $feed = $this->feedback->setData($dataObject);//TODO: Challenge Modify here to support the edit save functionality
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
        } else {
            $dataObject =[
                'firstName'=>$params['first_name'],
                'lastName'=>$params['last_name'],
                'email'=>$params['email'],
                'feedback'=>$params['feedback']
            ];
            $feed = $this->feedback->setData($dataObject);//TODO: Challenge Modify here to support the edit save functionality
            try {
                $this->feedbackResourceModel->save($feed);
                $this->messageManager->addSuccessMessage(__("Successfully added the feedback"));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__("Something went wrong."));
            }
            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath('');
            return $redirect;

        }

    }
}


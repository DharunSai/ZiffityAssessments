<?php

namespace Tasks\Feedback\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Escaper;

class Mail extends AbstractHelper
{
    protected $transportBuilder;
    protected $storeManager;
    protected $escaper;
    protected $inlineTranslation;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        StateInterface $state
    )
    {
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        parent::__construct($context);
    }
    public function sendEmail($email,$templateId)
    {
        // this is an example and you can change template id,fromEmail,toEmail,etc as per your need.
        // template id
        $fromEmail = 'dharundash@gmail.com';  // sender Email id
        $fromName = 'Admin';             // sender Name
        $toEmail = $email; // receiver email id

        try {
            // template variables pass here
            $templateVars = [
                'AcceptStatus'=>'accepted',
                'RejectStatus'=>'rejected'
            ];

            $storeId = $this->storeManager->getStore()->getId();

            $from = ['email' => $fromEmail, 'name' => $fromName];
            $this->inlineTranslation->suspend();

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
                'store' => $storeId
            ];
            $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($from)
                ->addTo([$toEmail])
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }
    }

}

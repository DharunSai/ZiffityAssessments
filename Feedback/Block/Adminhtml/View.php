<?php

namespace Tasks\Feedback\Block\Adminhtml;

use Tasks\Feedback\Model\FeedbackFactory;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Framework\UrlInterface;

class View extends Template
{
    protected $_request;
    protected $_coreRegistry;
    protected $_modelDataFactory;
    protected $_buttonList;
    protected $_url;
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        FeedbackFactory $DataFactory,
        UrlInterface $url,
        ButtonList $buttonList,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_modelDataFactory = $DataFactory;
        $this->_request = $request;
        $this->_buttonList = $buttonList;
        $this->_url = $url;
        parent::__construct($context, $data);
    }
    public function getFeedback()
    {
        return $this->_modelDataFactory->create()->load($this->_request->getParam('id'));
    }
    public function setAcceptUrl($email)
    {
        return  $this->_url->getUrl(
            'adminfeedback/mail/accept'
        ) . 'email/' . $email;
    }
    public function setRejectUrl($email)
    {
        return  $this->_url->getUrl(
            'adminfeedback/mail/reject'
        ) . 'email/' . $email;
    }
}

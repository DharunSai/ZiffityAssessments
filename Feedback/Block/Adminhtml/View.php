<?php

namespace Tasks\Feedback\Block\Adminhtml;

use Tasks\Feedback\Model\FeedbackFactory;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Request\Http;
use Magento\Backend\Block\Widget\Context;

/**
 * Adminhtml Feedback View Block
 *
 * @package Tasks\Feedback\Block\Adminhtml
 */
class View extends Template
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;

    /**
     * @var \Tasks\Feedback\Model\FeedbackFactory
     */
    protected $_modelDataFactory;

    /**
     * @var \Magento\Backend\Block\Widget\Button\ButtonList
     */
    protected $_buttonList;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    /**
     * View constructor.
     *
     * @param Context $context
     * @param Http $request
     * @param Registry $registry
     * @param FeedbackFactory $DataFactory
     * @param UrlInterface $url
     * @param ButtonList $buttonList
     * @param array $data
     */
    public function __construct(
        Context $context,
        Http $request,
        FeedbackFactory $dataFactory,
        UrlInterface $url,
        ButtonList $buttonList,
        array $data = []
    ) {
        $this->_modelDataFactory = $dataFactory;
        $this->_request = $request;
        $this->_buttonList = $buttonList;
        $this->_url = $url;
        parent::__construct($context, $data);
    }

    /**
     * Get Feedback Model
     *
     * @return \Tasks\Feedback\Model\Feedback
     */
    public function getFeedback()
    {
        return $this->_modelDataFactory->create()->load($this->_request->getParam('id'));
    }

    /**
     * Set Accept URL
     *
     * @param string $email
     * @return string
     */
    public function setAcceptUrl($email)
    {
        return  $this->_url->getUrl(
            'adminfeedback/mail/accept'
        ) . 'email/' . $email;
    }

    /**
     * Set Reject URL
     *
     * @param string $email
     * @return string
     */
    public function setRejectUrl($email)
    {
        return  $this->_url->getUrl(
            'adminfeedback/mail/reject'
        ) . 'email/' . $email;
    }
}

<?php

namespace Tasks\Feedback\Block;

use Magento\Framework\View\Element\Template;
use Tasks\Feedback\Model\ResourceModel\Feedback\Collection;
use \Magento\Framework\UrlInterface;
/**
 * Feedback Form Block
 *
 * @package Tasks\Feedback\Block
 */
class FeedbackForm extends Template
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * FeedbackForm constructor.
     *
     * @param Template\Context $context
     * @param Collection $collection
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Collection $collection,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->collection = $collection;
        parent::__construct($context, $data);
        $this->_urlBuilder = $urlBuilder;
    }

    /**
     * Get the URL for the feedback form submission action
     *
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('feedback/actions/save');
    }
}

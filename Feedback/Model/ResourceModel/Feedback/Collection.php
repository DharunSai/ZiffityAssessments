<?php

namespace Tasks\Feedback\Model\ResourceModel\Feedback;

use Tasks\Feedback\Model\Feedback as Feedback;
use Tasks\Feedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Feedback Collection Resource Model
 *
 * @package Tasks\Feedback\Model\ResourceModel\Feedback
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize the collection resource model
     */
    protected function _construct()
    {
        $this->_init(Feedback::class, FeedbackResourceModel::class);
    }
}

<?php

namespace Tasks\Feedback\Model\ResourceModel\Feedback;

use Tasks\Feedback\Model\Feedback as Feedback;
use Tasks\Feedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Feedback::class, FeedbackResourceModel::class);
    }
}

<?php

namespace Tasks\Feedback\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Feedback Resource Model
 *
 * @package Tasks\Feedback\Model\ResourceModel
 */
class Feedback extends AbstractDb
{
    /**
     * Main table name
     */
    const MAIN_TABLE = 'feedback_form';

    /**
     * Name of the primary key field
     */
    const ID_FIELD_NAME = 'id';

    /**
     * Initialize the resource model
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
